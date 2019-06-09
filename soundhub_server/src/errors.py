class UserDoesNotExists(Exception):
    def __init__(self):
        Exception.__init__(self, "User with the given username does not exists")


class PlaylistDoesNotExists(Exception):
    def __init__(self):
        Exception.__init__(self, "Playlist with the given username and title does not exists")


class MissingArgument(Exception):
    def __init__(self, args):
        Exception.__init__(self, f"Missing arguments: {args}")


class AlreadyExists(Exception):
    def __init__(self):
        Exception.__init__(self, f"Object already exists")


class InvalidFile(Exception):
    def __init__(self):
        Exception.__init__(self, "Invalid file")
