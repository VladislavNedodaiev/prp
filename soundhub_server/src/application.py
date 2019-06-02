from flask import Flask

from src.user_api import user_api

application = app = Flask(__name__)
app.register_blueprint(user_api, url_prefix='/api/v1/user')

if __name__ == "__main__":
    app.run(port=8000, debug=True)
