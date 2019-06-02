from hashlib import sha256
from uuid import uuid4

from src.models import *
from src.errors import *


class Driver:
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

    def _hash_password(self, password):
        salt = uuid4().hex
        return sha256(salt.encode() + password.encode()).hexdigest() + ':' + salt

    def _check_password(self, hashed_password, user_password):
        password, salt = hashed_password.split(':')
        return password == sha256(salt.encode() + user_password.encode()).hexdigest()
