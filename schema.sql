CREATE TABLE user_account (
    id serial PRIMARY KEY,
    username varchar(30) NOT NULL UNIQUE,
    password varchar(255) NOT NULL
);