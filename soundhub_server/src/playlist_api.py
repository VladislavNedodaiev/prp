import json

from flask import Blueprint, request, jsonify

from src.db_driver import PlaylistDriver
from src.errors import *
from src.models import Playlist

playlist_api = Blueprint('playlist_api', __name__)


@playlist_api.route("/", methods=['POST'])
def create_playlist():
    data = json.loads(request.data)

    driver = PlaylistDriver()
    try:
        playlist = driver.create(data)

        return jsonify(_playlist_data_to_dict(playlist)), 200
    except (AlreadyExists, UserDoesNotExists)as e:
        return jsonify({'message': str(e)}), 400


@playlist_api.route("/<string:username>/<string:title>", methods=['GET'])
def get_playlist(username, title):
    driver = PlaylistDriver()

    try:
        playlist = driver.get(username, title)
    except (PlaylistDoesNotExists, UserDoesNotExists) as e:
        return jsonify({'message': str(e)}), 400

    return jsonify(_playlist_data_to_dict(playlist)), 200


@playlist_api.route("/<string:username>/<string:title>", methods=['POST'])
def update_playlist(username, title):
    data = json.loads(request.data)

    driver = PlaylistDriver()
    try:
        playlist = driver.update(username, title, data)
        return jsonify(_playlist_data_to_dict(playlist)), 200
    except (PlaylistDoesNotExists, UserDoesNotExists, MissingArgument) as e:
        return jsonify({'message': str(e)}), 400


@playlist_api.route("/<string:username>/<string:title>", methods=['DELETE'])
def delete_playlist(username: str, title: str):
    driver = PlaylistDriver()

    try:
        driver.delete(username, title)
        return '', 200
    except (PlaylistDoesNotExists, UserDoesNotExists):
        return '', 404


@playlist_api.route("/<string:playlist_title>/like", methods=['POST'])
def like_playlist(playlist_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/unlike", methods=['POST'])
def unlike_playlist(playlist_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>", methods=['GET'])
def get_track(playlist_title: str, band: str, song_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>/like", methods=['POST'])
def like_track(playlist_title: str, band: str, song_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>/unlike", methods=['POST'])
def unlike_track(playlist_title: str, band: str, song_title: str):
    pass


def _playlist_data_to_dict(playlist: Playlist):
    playlist_data = {
        'author': playlist.author.username,
        'title': playlist.title,
        'date_of_creation': playlist.date_of_creation,
        'last_update': playlist.last_update,
        'description': playlist.description,
    }
    return playlist_data
