-- Feel free to change this to suit your needs.

CREATE TABLE users (
    id serial PRIMARY KEY,
    username TEXT,
    pubkey TEXT
);
CREATE UNIQUE INDEX ON users (username);

CREATE TABLE nonce (
    id serial PRIMARY KEY,
    message TEXT,
    created TIMESTAMP DEFAULT NOW(),
    user integer NOT NULL,
    FOREIGN KEY(user) REFERENCES users(id);
);
