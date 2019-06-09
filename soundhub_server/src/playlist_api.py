from flask import Blueprint, request, jsonify

playlist_api = Blueprint('playlist_api', __name__)


@playlist_api.route("/", methods=['POST'])
def create_playlist():
    pass


@playlist_api.route("/<string:playlist_title>", methods=['GET'])
def get_playlist(playlist_title: str):
    pass


@playlist_api.route("/<string:playlist_title>/update", methods=['POST'])
def update_playlist(playlist_title: str):
    pass


@playlist_api.route("/<string:playlist_title>", methods=['DELETE'])
def delete_playlist(playlist_title: str):
    pass


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
