from hashlib import sha256
from uuid import uuid4
import os
import eyed3

from src.models import *
from src.errors import *


class UserDriver:
    UPLOAD_PHOTO_FOLDER = '../Media/Photo/'
    PHOTO_EXTENSIONS = {'png', 'jpg', 'jpeg'}

    def register(self, data):
        args = ('username', 'password', 'email')

        if not all([arg in data.keys() for arg in args]):
            raise MissingArgument(args)

        password_hash = self._hash_password(data['password'])
        user = User(username=data['username'], password_hash=password_hash, email=data['email'])

        try:
            user.save()
            return user
        except IntegrityError:
            raise AlreadyExists()

    def auth(self, username, password):
        user = User.get(User.username == username)
        return self._check_password(user.password_hash, password)

    def get_by_username(self, username: str):
        try:
            user = User.get(User.username == username)
            return user
        except DoesNotExist:
            raise UserDoesNotExists()

    def set_user_photo(self, user, file):
        try:
            self._allowed_photo(file.filename)
        except InvalidFile:
            raise
        self.delete_user_photo(user)
        filename = self._rename_photo(file.filename, user.username)

        filepath = os.path.join(self.UPLOAD_PHOTO_FOLDER, filename)
        file.save(filepath)
        self._rename_photo(filename, user.username)
        user.photo_path = filepath
        user.save()
        return user

    def update_user(self, user: User, data: dict):
        args = ('email', 'phone', 'bio')

        if not any([key in args for key in data.keys()]):
            raise MissingArgument(args)

        for key, value in data.items():
            if key in args:
                setattr(user, key, value)
        user.save()
        return user

    def delete_user_photo(self, user):
        try:
            os.remove(user.photo_path)
        except (OSError, TypeError):
            pass

    def delete_user(self, user: User):
        user.delete_instance()

    def _hash_password(self, password):
        salt = uuid4().hex
        return sha256(salt.encode() + password.encode()).hexdigest() + ':' + salt

    def _check_password(self, hashed_password, user_password):
        password, salt = hashed_password.split(':')
        return password == sha256(salt.encode() + user_password.encode()).hexdigest()

    def _allowed_photo(self, filename):
        if not ('.' in filename and filename.rsplit('.', 1)[1].lower() in self.PHOTO_EXTENSIONS):
            raise InvalidFile()

    def _rename_photo(self, filename, username):
        ext_index = filename.rfind('.')
        ext = filename[ext_index:]
        new_filename = f'{username}_profile{ext}'
        return new_filename


class TrackDriver:
    UPLOAD_TRACK_FOLDER = '../Media/Audio/'
    TRACK_EXTENSIONS = {'.mp3'}

    def _rename_track(self, title, filename, author, band):
        ext_index = filename.rfind('.')
        ext = filename[ext_index:]
        new_filename = f'{title}_{author}_{band}'
        return new_filename

    def like(self, username: str, band: str, title: str):
        pass

    def unlike(self, username: str, band: str, title: str):
        pass

    def get_track(str, band: str, title: str):
        try:
            user = Track.get(Track.band == band, Track.title == title)
        except (PlaylistDoesNotExists, UserDoesNotExists) as e:
            return jsonify({'message': str(e)}), 400
        return jsonify(user)

    def upload(self, title, band, author, file, user: User):
        try:
            self._allowed_audio(file.filename)
        except InvalidFile:
            raise

        self._rename_photo(title, file, author, band)
        filepath = os.path.join(self.UPLOAD_PHOTO_FOLDER, file)
        file.save(filepath)

        track = Track(author=author, band=band, title=title, \
            duration = eyed3.load(filepath).info.time_secs, filepath=filepath)

        if not playlist.author == user:
            raise PermissionError()

        track.save()
        return track

    def add_to_playlist(self, username, playlist, track: Track):
        pass

    def remove_from_playlist(self, username, playlist, track: Track):
        pass

    def _allowed_audio(self, filename):
        if not ('.' in filename and filename.rsplit('.', 1)[1].lower() in self.TRACK_EXTENSIONS):
            raise InvalidFile()


class PlaylistDriver:

    def create(self, data):
        args = ('username', 'title')
        user_driver = UserDriver()

        if not all([arg in data.keys() for arg in args]):
            raise MissingArgument(args)
        try:
            author = user_driver.get_by_username(username=data['username'])
            playlist = Playlist(author=author, title=data['title'])
            if 'description' in data.keys():
                playlist.description = data['description']

            playlist.save()
            return playlist
        except UserDoesNotExists:
            raise
        except IntegrityError:
            raise AlreadyExists()

    def update(self, username, title, data):
        args = ('desctiption', 'title')

        if not any([arg in data.keys() for arg in args]):
            raise MissingArgument(args)

        try:
            playlist = self.get(username, title)
        except (UserDoesNotExists, PlaylistDoesNotExists):
            raise

        for key, value in data.items():
            if key in args:
                setattr(playlist, key, value)

        playlist.save()
        return playlist

    def get(self, author_username: str, title: str):
        user_driver = UserDriver()
        try:
            author = user_driver.get_by_username(username=author_username)
            playlist = Playlist.get(Playlist.author == author, Playlist.title == title)
            return playlist
        except UserDoesNotExists:
            raise
        except DoesNotExist:
            raise PlaylistDoesNotExists()

    def delete(self, playlist: Playlist):
        playlist.delete_instance()

    def delete(self, username, title):
        try:
            playlist = self.get(username, title)
            playlist.delete_instance()
        except (UserDoesNotExists, PlaylistDoesNotExists):
            raise


class TrackLikeDriver:
    def check_if_liked(track, user):
        like = Like(Like.track == track, Like.user == user)
        if not like:
            return False
        return True

    def like(track, user):
        if check_if_liked(track, user):
            raise TrackAlreadyLiked()
        like = Like(track=track, user=user)
        return like

    def unlike(track, user):
        if not check_if_liked(track, user):
            raise TrackLikeNotFound()
        like = Like.get(Like.track==track, Like.user==user)
        like.delete_instance()
        return like