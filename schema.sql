CREATE DATABASE readme
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE readme;

CREATE TABLE users (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     email VARCHAR(320),
                     password VARCHAR(320),
                     login CHAR(64),
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     avatar TEXT
);

CREATE TABLE cont_types (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          type ENUM('small'),
                          name ENUM('small')
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
                     reposts INT,
                     user_id INT,
                     cont_type_id INT,
                     FOREIGN KEY (user_id) REFERENCES users (id),
                     FOREIGN KEY (cont_type_id) REFERENCES cont_types (id)
);

CREATE TABLE tags (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    tag_name CHAR(64)
);

CREATE TABLE posts_tags (
                         post_id INT,
                         FOREIGN KEY (post_id) REFERENCES posts (id),
                         tag_id INT,
                         FOREIGN KEY (tag_id) REFERENCES tags (id),
                         PRIMARY KEY (post_id, tag_id)
);

CREATE TABLE comments (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        content TEXT,
                        user_id INT,
                        FOREIGN KEY (user_id) REFERENCES users (id),
                        post_id INT,
                        FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE messages (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        content TEXT,
                        sender_id INT,
                        FOREIGN KEY (sender_id) REFERENCES users (id),
                        recipient_id INT,
                        FOREIGN KEY (recipient_id) REFERENCES users (id)
);

CREATE TABLE likes (
                     user_id INT,
                     FOREIGN KEY (user_id) REFERENCES users (id),
                     post_id INT,
                     FOREIGN KEY (post_id) REFERENCES posts (id),
                     CONSTRAINT likes_pk PRIMARY KEY (user_id, post_id)
);

CREATE TABLE subscribes (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          follower_id INT,
                          FOREIGN KEY (follower_id) REFERENCES users (id),
                          follow_id INT,
                          FOREIGN KEY (follow_id) REFERENCES users (id)
);

