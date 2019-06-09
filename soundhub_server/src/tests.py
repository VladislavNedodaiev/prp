import sys
import unittest

from src.db_driver import UserDriver
from src.models import *
from src.errors import *

MODELS = [User, Track, Playlist, PlaylistTracks, Like, Genre, TrackGenre, Subscription]
test_db = SqliteDatabase(':memory:')


class BaseTestCase(unittest.TestCase):
    def setUp(self):
        test_db.bind(MODELS, bind_refs=False, bind_backrefs=False)

        test_db.connect()
        test_db.create_tables(MODELS)

    def tearDown(self):
        test_db.drop_tables(MODELS)
        test_db.close()


class TestUser(BaseTestCase):

    def test_db_connection(self):
        user1 = User(
            username='user1',
            password_hash='12345678',
            email="user1@gmail.com"
        )
        user1.save()

        users_count = len(User.select())
        self.assertEqual(users_count, 1)

    def test_register(self):
        driver = UserDriver()

        user = driver.register('testusername', 'testpassword', 'testemail@gmail.com')
        self.assertEqual(user, User.get(User.username == 'testusername'))

    def test_register_exists(self):
        driver = UserDriver()

        with self.assertRaises(AlreadyExists):
            user1 = driver.register('same_username', 'testpassword1', 'testemail1@gmail.com')
            user2 = driver.register('same_username', 'testpassword2', 'testemail2@gmail.com')
            user1.save()
            user2.save()

    def test_auth(self):
        driver = UserDriver()

        user_password = 'sajb4aisNsa83'
        user = driver.register('testusername', user_password, 'testemail@gmail.com')

        self.assertEqual(driver.auth(user.username, user_password), True)
        self.assertEqual(driver.auth(user.username, user.password_hash), False)

    def test_get_by_username(self):
        driver = UserDriver()
        username = 'testusername'
        user = driver.register(username, 'testpassword228', 'testemail@gmail.com')

        self.assertEqual(user.username, username)
        with self.assertRaises(UserDoesNotExists):
            driver.get_by_username('not_existing_username')


class TestTrack(BaseTestCase):
    def test_create(self):
        author = User(
            username='user1',
            password_hash='12345678',
            email='user1@gmail.com'
        )
        author.save()
        description = """
            Some
            Very
            Long
            Multiline
            Text
        """
        playlist = Playlist(
            author=author,
            title='sample',
            description=description
        )
        playlist.save()

        self.assertEqual(author, playlist.author)
        self.assertTrue(playlist in author.playlists)
        self.assertEqual(len(author.playlists), 1)
        self.assertEqual(playlist.description, description)


if __name__ == '__main__':
    suite = unittest.TestLoader().loadTestsFromModule(sys.modules[__name__])
    unittest.TextTestRunner(verbosity=2).run(suite)
