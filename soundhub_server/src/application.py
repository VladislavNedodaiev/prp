from flask import Flask

from src.user_api import user_api
from src.playlist_api import playlist_api

application = app = Flask(__name__)

app.register_blueprint(user_api, url_prefix='/api/v1/users')
app.register_blueprint(playlist_api, url_prefix='/api/v1/playlists')

if __name__ == "__main__":
    app.run(port=8000, debug=True)
