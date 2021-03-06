CREATE DATABASE readme
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE readme;

CREATE TABLE users (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     email VARCHAR(320) NOT NULL,
                     password CHAR(64) NOT NULL,
                     login VARCHAR(320) NOT NULL,
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     avatar TEXT DEFAULT NULL,
                     UNIQUE INDEX UI_email (email),
                     UNIQUE INDEX UI_login (login)
);

CREATE TABLE content_type (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(128) NOT NULL,
                            type VARCHAR(128) NOT NULL,
                            UNIQUE INDEX UI_type (type)
);

CREATE TABLE posts (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     title VARCHAR(128) NOT NULL,
                     text TEXT DEFAULT NULL,
                     quote_auth VARCHAR(128) DEFAULT NULL,
                     img VARCHAR(320) DEFAULT NULL,
                     video TEXT DEFAULT NULL,
                     link VARCHAR(320) DEFAULT NULL,
                     views INT DEFAULT 0,
                     original_id INT DEFAULT NULL,
                     user_id INT NOT NULL,
                     content_type_id INT NOT NULL,
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     FOREIGN KEY (content_type_id) REFERENCES content_type(id),
                     FOREIGN KEY (user_id) REFERENCES users (id),
                     FOREIGN KEY (original_id) REFERENCES posts (id)
);

CREATE TABLE tags (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name CHAR(64) DEFAULT NULL,
                    UNIQUE INDEX UI_tag (name)
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
                        content TEXT NOT NULL,
                        user_id INT NOT NULL,
                        FOREIGN KEY (user_id) REFERENCES users (id),
                        post_id INT NOT NULL,
                        FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE messages (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        content TEXT NOT NULL,
                        sender_id INT NOT NULL,
                        is_read bool NOT NULL DEFAULT false,
                        FOREIGN KEY (sender_id) REFERENCES users (id),
                        recipient_id INT NOT NULL,
                        FOREIGN KEY (recipient_id) REFERENCES users (id)
);

CREATE TABLE likes (
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     user_id INT NOT NULL,
                     FOREIGN KEY (user_id) REFERENCES users (id),
                     post_id INT NOT NULL,
                     FOREIGN KEY (post_id) REFERENCES posts (id),
                     CONSTRAINT likes_pk PRIMARY KEY (user_id, post_id)
);

CREATE TABLE subscribes (
                          follower_id INT NOT NULL,
                          FOREIGN KEY (follower_id) REFERENCES users (id),
                          follow_id INT NOT NULL,
                          FOREIGN KEY (follow_id) REFERENCES users (id),
                          CONSTRAINT subscribes PRIMARY KEY (follower_id, follow_id)
);

CREATE FULLTEXT INDEX posts_title_text_search ON posts(title, text);
