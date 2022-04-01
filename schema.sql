CREATE DATABASE readme
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE readme;

CREATE TABLE users (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     email VARCHAR(128),
                     password CHAR(64),
                     login CHAR(64),
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     avatar TEXT
);

CREATE TABLE posts (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     title VARCHAR(128),
                     text TEXT,
                     quote_auth VARCHAR(128),
                     img TEXT,
                     video TEXT,
                     link TEXT,
                     views INT,
                     user_id INT,
                     cont_type_id INT,
                     tag_id INT
);

CREATE TABLE comments (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        content TEXT,
                        user_id INT,
                        post_id INT
);

CREATE TABLE messages (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        content TEXT,
                        sender_id INT,
                        recipient_id INT
);

CREATE TABLE tags (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    tag CHAR(64)
);

CREATE TABLE likes (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     user_id INT,
                     post_id INT
);

CREATE TABLE subscribes (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          follower_id INT,
                          follow_id INT
);

CREATE TABLE cont_types (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          type CHAR(64),
                          name CHAR(64)
);
