# Author: Benjamin Medicke

from flask import g
import sqlite3


# get database and cursor to database:
def get_db_objects():
    db = getattr(g, "_database", None)  # g._database or None.
    if db is None:
        db = g._database = sqlite3.connect("smart.db")

    db.row_factory = dict_factory  # define serialization rules.
    cursor = db.cursor()  # get cursor to execute SQL statements with.
    return (db, cursor)


# close db connection:
def close_db_connection():
    db = getattr(g, "_database", None)
    if db is not None:
        db.close()


# row serialization factory:
def dict_factory(cursor, row):
    d = {}
    for idx, col in enumerate(cursor.description):
        d[col[0]] = row[idx]
    return d


# create table, if it does not exist already:
def create_lights_table(cursor):
    cursor.execute(
        """CREATE TABLE IF NOT EXISTS lights (
        id text not null,
        timestamp integer not null,
        name text not null,
        status integer not null,
        brightness integer not null
        )"""
    )


# create table, if it does not exist already:
def create_blinds_table(cursor):
    cursor.execute(
        """CREATE TABLE IF NOT EXISTS blinds (
        id text not null,
        timestamp integer not null,
        name text not null,
        status integer not null
        )"""
    )

# create table, if it does not exist already:
def create_scenes_table(cursor):
    cursor.execute(
        """CREATE TABLE IF NOT EXISTS scenes (
        scene_id text not null,
        name text not null,
        light_id text not null,
        brightness integer not null,
        status integer not null
        )"""
    )
