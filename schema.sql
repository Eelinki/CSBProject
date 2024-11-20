CREATE TABLE user_account (
    id serial PRIMARY KEY,
    username varchar(30) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    is_admin boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE file (
    id serial PRIMARY KEY,
    user_id integer NOT NULL REFERENCES user_account (id) ON UPDATE CASCADE ON DELETE CASCADE,
    filename varchar(255) NOT NULL
)