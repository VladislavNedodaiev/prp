from hashlib import sha256
from uuid import uuid4
import os

from src.models import *
from src.errors import *


class Driver:
    UPLOAD_PHOTO_FOLDER = '../Media/Photo/'
    PHOTO_EXTENSIONS = {'png', 'jpg', 'jpeg'}

    def register(self, username, password, email):
        password_hash = self._hash_password(password)
        user = User(username=username, password_hash=password_hash, email=email)

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

        filename = self._rename_photo(file.filename, user.username)
        filepath = os.path.join(self.UPLOAD_PHOTO_FOLDER, filename)
        file.save(filepath)
        self._rename_photo(filename, user.username)

        user.photo_path = filepath
        user.save()
        return user

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
