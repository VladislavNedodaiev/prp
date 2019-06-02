import unittest
from src.db_driver import Driver
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
        driver = Driver()

        user = driver.register('testusername', 'testpassword', 'testemail@gmail.com')
        self.assertEqual(user, User.get(User.username == 'testusername'))

    def test_register_exists(self):
        driver = Driver()

        with self.assertRaises(AlreadyExists):
            user1 = driver.register('same_username', 'testpassword1', 'testemail1@gmail.com')
            user2 = driver.register('same_username', 'testpassword2', 'testemail2@gmail.com')
            user1.save()
            user2.save()

    def test_auth(self):
        driver = Driver()

        user_password = 'sajb4aisNsa83'
        user = driver.register('testusername', user_password, 'testemail@gmail.com')

        self.assertEqual(driver.auth(user.username, user_password), True)
        self.assertEqual(driver.auth(user.username, user.password_hash), False)

    def test_get_by_username(self):
        driver = Driver()
        username = 'testusername'
        user = driver.register(username, 'testpassword228', 'testemail@gmail.com')

        self.assertEqual(user.username, username)
        with self.assertRaises(UserDoesNotExists):
            driver.get_by_username('not_existing_username')


if __name__ == '__main__':
    suite = unittest.TestLoader().loadTestsFromTestCase(TestUser)
    unittest.TextTestRunner(verbosity=2).run(suite)
