import json

from flask import Blueprint, request, jsonify

from src.db_driver import PlaylistDriver
from src.errors import *
from src.models import Playlist

from src.playlist_api import _playlist_data_to_dict

playlist_api = Blueprint('track_api', __name__)

@playlist_api.route("/<string:username>/", methods=['POST'])
def create_track(username: str):
    try:
        driver = TrackDriver()
        
        user = UserDriver().get_by_username(username)
        file = request.files['file']
        data = json.loads(request.data)
        track = driver.create_track(data["title"], data["band"], data["author"], file, user)
        response = _track_data_to_dict(track)
        return jsonify(response), 200
    except (UserDoesNotExists, InvalidFile)as e:
        return jsonify({'message': str(e)})
    except exceptions.HTTPException:
        return jsonify({'message': "Missing 'file' key"}), 400
    except Exception as e:
        return jsonify({'message': str(e)})

@playlist_api.route("/<string:song_title>/<string:band>", methods=['GET'])
def get_track(playlist_title: str, band: str, song_title: str):
    driver = TrackDriver()

    try:
        track = driver.get(band, song_title)
    except (TrackDoesNotExists) as e:
        return jsonify({'message': str(e)}), 400
    except Exception as e:
        return jsonify({'message': str(e)}), 400

    return jsonify(_track_data_to_dict(track)), 200

@playlist_api.route("/<string:band>/<string:song_title>/like", methods=['POST'])
def like_track(band: str, song_title: str):
    data = json.loads(request.data)
    username = data['username']
    u_driver = UserDriver()
    t_driver = TrackDriver()
    driver = LikeDriver()

    try:
        user = u_driver.get_by_username(username)
        track = t_driver.get_track(band, song_title)
        like = driver.like(user, track)

        return jsonify(_like_data_to_dict(like))
        
    except (TrackDoesNotExists) as e:
        return jsonify({'message': str(e)}), 400
    except TrackAlreadyLiked as e:
        return jsonify({'message': str(e)}), 400
    except Exception as e:
        return jsonify({'message': str(e)}), 400


@playlist_api.route("/<string:band>/<string:song_title>/unlike", methods=['POST'])
def unlike_track(band: str, song_title: str):
    data = json.loads(request.data)
    username = data['username']
    u_driver = UserDriver()
    t_driver = TrackDriver()
    driver = LikeDriver()

    try:
        user = u_driver.get_by_username(username)
        track = t_driver.get_track(band, song_title)
        like = driver.unlike(track, user)

        return jsonify(_like_data_to_dict(like))
        
    except (TrackDoesNotExists) as e:
        return jsonify({'message': str(e)}), 400
    except TrackAlreadyLiked as e:
        return jsonify({'message': str(e)}), 400
    except Exception as e:
        return jsonify({'message': str(e)}), 400


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
    
def _like_data_to_dict(like: Like):
    like_data = {
        'author': like.track,
        'user': like.user,
    }
    return like_data