import json

from flask import Blueprint, request, jsonify

from src.db_driver import Driver
from src.errors import *
from src.models import *

user_api = Blueprint('user_api', __name__)


@user_api.route("/<string:username>", methods=['GET'])
def get_user(username: str):
    try:
        driver = Driver()
        user = driver.get_by_username(username)
    except UserDoesNotExists as e:
        return jsonify({'message': str(e)}), 404

    response = _user_data_to_dict(user)
    return jsonify(response), 200


@user_api.route("/", methods=['POST'])
def create_user():
    args = ['username', 'password', 'email']
    data = json.loads(request.data)

    if not all([arg in data.keys() for arg in args]):
        return jsonify({'message': f'Missing some of the arguments:{args}'}), 400

    driver = Driver()
    try:
        user = driver.register(data['username'], data['password'], data['email'])
    except AlreadyExists as e:
        return jsonify({'message': str(e)}), 400

    response = _user_data_to_dict(user)
    return jsonify(response), 200


def _user_data_to_dict(user: User) -> dict:
    user_data = {
        'username': user.username,
        'email': user.email,
        'phone': user.phone,
        'date_of_reg': user.date_of_reg,
        'balance': user.balance,
        'is_premium': user.is_premium,
        'premium_exp_date': user.premium_exp_date
    }
    return user_data
