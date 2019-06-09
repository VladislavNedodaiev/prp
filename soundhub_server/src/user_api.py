import json

from flask import Blueprint, request, jsonify
from werkzeug import exceptions

from src.db_driver import UserDriver
from src.errors import *
from src.models import *

user_api = Blueprint('user_api', __name__)

UPLOAD_PHOTO_FOLDER = '../Media/Photo/'
UPLOAD_TRACK_FOLDER = '../Media/Audio/'
PHOTO_EXTENSIONS = {'png', 'jpg', 'jpeg'}


@user_api.route("/<string:username>", methods=['GET'])
def get_user(username: str):
    try:
        driver = UserDriver()
        user = driver.get_by_username(username)
    except UserDoesNotExists as e:
        return jsonify({'message': str(e)}), 404

    response = _user_data_to_dict(user)
    return jsonify(response), 200


@user_api.route("/<string:username>/update", methods=['POST'])
def update_user(username: str):
    data = json.loads(request.data)
    try:
        driver = UserDriver()
        user = driver.get_by_username(username)
        responce_body = _user_data_to_dict(driver.update_user(user, data))
        return jsonify(responce_body), 200
    except (UserDoesNotExists, MissingArgument) as e:
        return jsonify({'message': str(e)}), 404


@user_api.route("/", methods=['POST'])
def create_user():
    args = ['username', 'password', 'email']
    data = json.loads(request.data)

    if not all([arg in data.keys() for arg in args]):
        return jsonify({'message': f'Missing some of the arguments:{args}'}), 400

    driver = UserDriver()
    try:
        user = driver.register(data['username'], data['password'], data['email'])
    except AlreadyExists as e:
        return jsonify({'message': str(e)}), 400

    response = _user_data_to_dict(user)
    return jsonify(response), 200


@user_api.route("/<string:username>", methods=['DELETE'])
def delete_user(username: str):
    driver = UserDriver()
    try:
        user = driver.get_by_username(username)
        driver.delete_user(user)
        return '', 200
    except UserDoesNotExists:
        return '', 404


@user_api.route("/<string:username>/set_photo", methods=['POST'])
def set_photo(username: str):
    try:
        driver = UserDriver()
        user = driver.get_by_username(username)
        file = request.files['photo']
        user = driver.set_user_photo(user, file)
        response = _user_data_to_dict(user)
        return jsonify(response), 200
    except (UserDoesNotExists, InvalidFile)as e:
        return jsonify({'message': str(e)})
    except exceptions.HTTPException:
        return jsonify({'message': "Missing 'photo' key"}), 400


def _user_data_to_dict(user: User) -> dict:
    user_data = {
        'username': user.username,
        'email': user.email,
        'phone': user.phone,
        'date_of_reg': user.date_of_reg,
        'balance': user.balance,
        'is_premium': user.is_premium,
        'premium_exp_date': user.premium_exp_date,
        'photo_path': user.photo_path,
        'bio': user.bio
    }
    return user_data
