from peewee import *
from datetime import datetime

db = SqliteDatabase('soundhub.db')


class BaseModel(Model):
    class Meta:
        database = db


class User(BaseModel):
    username = CharField(unique=True)
    password_hash = CharField()
    photo_path = CharField(null=True)
    bio = TextField(null=True)
    phone = CharField(null=True)
    date_of_reg = DateField(default=datetime.date(datetime.now()))
    email = CharField(null=True)
    balance = FloatField(default=0)
    is_premium = BooleanField(default=False)
    premium_exp_date = DateField(null=True)


class Track(BaseModel):
    author = ForeignKeyField(User, backref="songs")
    band = CharField()
    title = CharField()
    date_of_pub = DateField(default=datetime.date(datetime.now()))
    duration = SmallIntegerField(null=True)  # in seconds
    file_path = CharField()


class Playlist(BaseModel):
    author = ForeignKeyField(User, backref="playlists")
    title = CharField(unique=True)
    date_of_creation = DateField(default=datetime.date(datetime.now()))
    last_update = DateField(null=True)
    description = TextField(null=True)
    photo_path = CharField(null=True)


class PlaylistTracks(BaseModel):
    track = ForeignKeyField(Track, backref="playlists", null=True)
    playlist = ForeignKeyField(Playlist, backref="tracks")


class Like(BaseModel):
    track = ForeignKeyField(Track, backref="liked")
    user = ForeignKeyField(User, backref="liked")


class Genre(BaseModel):
    title = CharField()


class TrackGenre(BaseModel):
    genre = ForeignKeyField(Genre, backref="track")
    track = ForeignKeyField(Track, backref="genre", null=True)


class Subscription(BaseModel):
    subscriber = ForeignKeyField(User, backref="subscriptions", null=True)
    subscribed_user = ForeignKeyField(User, backref="subscribers", null=True)


def create_tables():
    MODELS = [User, Track, Playlist, PlaylistTracks, Like, Genre, TrackGenre, Subscription]
    db.connect()
    db.create_tables(MODELS)

