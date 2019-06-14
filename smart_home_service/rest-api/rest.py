# Author: Benjamin Medicke

API_KEY = "be81dc5b-bb41-46ad-8ad4-890d70626c77"
WHITELISTED_IP = "0.0.0.0"

from flask import Flask, request, Response, jsonify, g
from flask_cors import CORS
from functools import wraps
from time import time
import json
import sqlite3
import uuid

app = Flask(__name__)
CORS(app)  # for calls via JavaScript.

import dbutil

# clean up after ourselves:
@app.teardown_appcontext
def teardown(exception):
    dbutil.close_db_connection()


# decorator that requires the requesting ip to be whitelisted:
def only_whitelisted_ip(old_function):
    @wraps(old_function)
    def wrapper(*args, **kwds):
        if request.remote_addr != WHITELISTED_IP:
            return (
                jsonify(
                    dict(status="not authorized", ip=request.remote_addr, error=True)
                ),
                401,
            )
        return old_function(*args, **kwds)

    return wrapper


# decorator that adds an API key requirement to a request:
def requires_api_key(old_function):
    @wraps(old_function)
    def wrapper(*args, **kwds):
        headers = request.headers
        api_key = headers.get("X-Api-Key")
        if api_key != API_KEY:
            return (
                jsonify(dict(status="not authorized", api_key=api_key, error=True)),
                401,
            )
        else:
            return old_function(*args, **kwds)

    return wrapper


# endpoint to test authentication:
@app.route("/api")
@only_whitelisted_ip
@requires_api_key
def api_get():
    return jsonify(dict(status="ok", error=False)), 200


## LIGHTS endpoints ##


# get a json array of all known lights:
@app.route("/api/lights", methods=["GET"])
@requires_api_key
def lights_get():
    db, cursor = dbutil.get_db_objects()

    # check for lights:
    try:
        cursor.execute("SELECT * FROM lights")
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(cursor.fetchall()), 200


# read json object and create new light from it:
@app.route("/api/lights", methods=["POST"])
@requires_api_key
def lights_post():
    db, cursor = dbutil.get_db_objects()

    dbutil.create_lights_table(cursor)

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    post_data["id"] = str(uuid.uuid4())  # add unique id to avoid pkey in db.
    post_data["timestamp"] = int(time())  # add timestamp.
    post_data["status"] = False  # lights are off after creation.
    post_data["brightness"] = 0  # brightness is zero by default.

    # write received post data into db:
    try:
        with db:
            cursor.execute(
                """INSERT INTO lights VALUES (
                :id,
                :timestamp,
                :name,
                :status,
                :brightness
                )""",
                post_data,
            )
    except sqlite3.ProgrammingError:
        return jsonify(dict(status="incomplete json"))

    return jsonify(status="ok"), 200


# delete all known lights:
@app.route("/api/lights", methods=["DELETE"])
@requires_api_key
def lights_delete():
    db, cursor = dbutil.get_db_objects()
    cursor = db.cursor()

    with db:
        cursor.execute("DROP TABLE IF EXISTS lights")
    return jsonify(dict(status="ok")), 200


# set status and brightness of all lights:
@app.route("/api/lights", methods=["PUT"])
@requires_api_key
def lights_put():
    db, cursor = dbutil.get_db_objects()

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    try:
        cursor.execute(
            "UPDATE lights SET status=?, brightness=?",
            (int(post_data["status"]), int(post_data["brightness"])),
        )
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200
    except KeyError:
        return jsonify(dict(status="json incomplete", error=True)), 200

    db.commit()

    return jsonify(status="ok"), 200


# get state of a specific light:
@app.route("/api/lights/<light_id>", methods=["GET"])
@requires_api_key
def lights_id_get(light_id):
    db, cursor = dbutil.get_db_objects()

    # check for lights:
    try:
        cursor.execute("SELECT * FROM lights WHERE id=?", (light_id,))
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    r = cursor.fetchone()
    if r == None:
        return jsonify(dict(status="light not found", error=True)), 200

    return jsonify(r), 200


# delete a specific light:
@app.route("/api/lights/<light_id>", methods=["DELETE"])
@requires_api_key
def lights_id_delete(light_id):
    db, cursor = dbutil.get_db_objects()

    # delete light with matching id:
    try:
        cursor.execute("DELETE FROM lights WHERE id=?", (light_id,))
        db.commit()
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(dict(status="light gone")), 200


# set status and brightness of a specific light:
@app.route("/api/lights/<light_id>", methods=["PUT"])
@requires_api_key
def lights_id_put(light_id):
    db, cursor = dbutil.get_db_objects()

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    try:
        cursor.execute(
            "UPDATE lights SET status=?, brightness=? WHERE id=?",
            (int(post_data["status"]), int(post_data["brightness"]), light_id),
        )
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200
    except KeyError:
        return jsonify(dict(status="json incomplete", error=True)), 200

    db.commit()

    return jsonify(status="ok"), 200


## BLINDS endpoints ##


# get a json array of all known blinds:
@app.route("/api/blinds", methods=["GET"])
@requires_api_key
def blinds_get():
    db, cursor = dbutil.get_db_objects()

    # check for blinds:
    try:
        cursor.execute("SELECT * FROM blinds")
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(cursor.fetchall()), 200


# read json object and crete a new blind from it:
@app.route("/api/blinds", methods=["POST"])
@requires_api_key
def blinds_post():
    db, cursor = dbutil.get_db_objects()
    dbutil.create_blinds_table(cursor)

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    post_data["id"] = str(uuid.uuid4())  # add unique id to avoid pkey in db.
    post_data["timestamp"] = int(time())  # add timestamp.
    post_data["status"] = 0  # blinds are off after creation.

    # write received post data into db:
    try:
        with db:
            cursor.execute(
                """INSERT INTO blinds VALUES (
                :id,
                :timestamp,
                :name,
                :status
                )""",
                post_data,
            )
    except sqlite3.ProgrammingError:
        return jsonify(dict(status="incomplete json"))

    return jsonify(status="ok"), 200


# delete all known blinds:
@app.route("/api/blinds", methods=["DELETE"])
@requires_api_key
def blinds_delete():
    db, cursor = dbutil.get_db_objects()

    with db:
        cursor.execute("DROP TABLE IF EXISTS blinds")
    return jsonify(dict(status="ok")), 200


# set status of all blinds:
@app.route("/api/blinds", methods=["PUT"])
@requires_api_key
def blinds_put():
    db, cursor = dbutil.get_db_objects()

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    try:
        cursor.execute("UPDATE blinds SET status=?", (int(post_data["status"]),))
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200
    except KeyError:
        return jsonify(dict(status="json incomplete", error=True)), 200

    db.commit()

    return jsonify(status="ok"), 200


# get status of a specific light:
@app.route("/api/blinds/<blind_id>", methods=["GET"])
@requires_api_key
def blinds_id_get(blind_id):
    db, cursor = dbutil.get_db_objects()

    # check for blinds:
    try:
        cursor.execute("SELECT * FROM blinds WHERE id=?", (blind_id,))
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    r = cursor.fetchone()
    if r == None:
        return jsonify(dict(status="blind not found", error=True)), 200

    return jsonify(r), 200


# delete a specific blind:
@app.route("/api/blinds/<blind_id>", methods=["DELETE"])
@requires_api_key
def blinds_id_delete(blind_id):
    db, cursor = dbutil.get_db_objects()

    # delete blind with matching id:
    try:
        cursor.execute("DELETE FROM blinds WHERE id=?", (blind_id,))
        db.commit()
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(dict(status="blind gone")), 200


# set status of a specific blind:
@app.route("/api/blinds/<blind_id>", methods=["PUT"])
@requires_api_key
def blinds_id_put(blind_id):
    db, cursor = dbutil.get_db_objects()

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    try:
        cursor.execute(
            "UPDATE blinds SET status=? WHERE id=?",
            (int(post_data["status"]), blind_id),
        )
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200
    except KeyError:
        return jsonify(dict(status="json incomplete", error=True)), 200

    db.commit()

    return jsonify(status="ok"), 200


## SCENES endpoints ###


# get json array of all known scene definitions:
@app.route("/api/scenes", methods=["GET"])
@requires_api_key
def scenes_get():
    db, cursor = dbutil.get_db_objects()

    # check for scenes:
    try:
        cursor.execute("SELECT * FROM scenes")
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(cursor.fetchall()), 200


# read json array and create new scene from it:
@app.route("/api/scenes", methods=["POST"])
@requires_api_key
def scenes_post():
    db, cursor = dbutil.get_db_objects()

    dbutil.create_scenes_table(cursor)

    post_data = request.get_json(silent=True)
    if post_data == None:
        return jsonify(dict(status="invalid json", error=True)), 200

    u = str(uuid.uuid4())
    # write received post data into db:
    try:
        with db:
            for i in post_data:
                i["scene_id"] = u
                cursor.execute(
                    """INSERT INTO scenes VALUES (
                    :scene_id,
                    :name,
                    :light_id,
                    :brightness,
                    :status
                    )""",
                    i,
                )
    except sqlite3.ProgrammingError:
        return jsonify(dict(status="incomplete json"))

    return jsonify(status="ok"), 200


# delete all known scenes:
@app.route("/api/scenes", methods=["DELETE"])
@requires_api_key
def scenes_delete():
    db, cursor = dbutil.get_db_objects()
    cursor = db.cursor()

    with db:
        cursor.execute("DROP TABLE IF EXISTS scenes")
    return jsonify(dict(status="ok")), 200


# activate a specific scene:
@app.route("/api/scenes/<scene_id>", methods=["GET"])
@requires_api_key
def scenes_id_put(scene_id):
    db, cursor = dbutil.get_db_objects()

    # check for scenes:
    try:
        cursor.execute("SELECT * FROM scenes WHERE scene_id=?", (scene_id,))
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    try:
        for i in cursor.fetchall():
            print(i["light_id"], i["brightness"], i["status"], flush=True)
            cursor.execute(
                "UPDATE lights SET status=?, brightness=? WHERE id=?",
                (i["status"], i["brightness"], i["light_id"]),
            )
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    db.commit()

    return jsonify(status="ok"), 200


# delete a specific scene:
@app.route("/api/scenes/<scene_id>", methods=["DELETE"])
@requires_api_key
def scenes_id_delete(scene_id):
    db, cursor = dbutil.get_db_objects()

    # delete scene with matching id:
    try:
        cursor.execute("DELETE FROM scenes WHERE scene_id=?", (scene_id,))
        db.commit()
    except sqlite3.OperationalError:
        return jsonify(dict(status="table not found", error=True)), 200

    return jsonify(dict(status="scene gone")), 200
