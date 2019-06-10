import json

from flask import Blueprint, request, jsonify

from src.db_driver import PlaylistDriver
from src.errors import *
from src.models import Playlist

playlist_api = Blueprint('track_api', __name__)


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>", methods=['GET'])
def get_track(playlist_title: str, band: str, song_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>/like", methods=['POST'])
def like_track(playlist_title: str, band: str, song_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/<string:band>/<string:song_title>/unlike", methods=['POST'])
def unlike_track(playlist_title: str, band: str, song_title: str):
    pass


def _track_data_to_dict(track: Track):
    track_data = {
        'author': track.author.username,
        'band': track.band,
        'title': track.title,
        'date_of_pub': track.date_of_pub,
        'duration': track.duration,
        'file_path': track.file_path,
    }
    return track_data
