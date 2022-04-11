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

CREATE TABLE posts (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     title VARCHAR(128) NOT NULL,
                     text TEXT DEFAULT NULL,
                     quote_auth VARCHAR(128) DEFAULT NULL,
                     img TEXT DEFAULT NULL,
                     video TEXT DEFAULT NULL,
                     link TEXT DEFAULT NULL,
                     views INT DEFAULT 0,
                     original_id INT DEFAULT NULL,
                     user_id INT NOT NULL,
                     content_type ENUM('post-text', 'post-quote', 'post-photo', 'post-video', 'post-link') NOT NULL,
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
                        FOREIGN KEY (sender_id) REFERENCES users (id),
                        recipient_id INT NOT NULL,
                        FOREIGN KEY (recipient_id) REFERENCES users (id)
);

CREATE TABLE likes (
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

CREATE TABLE content_type (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name CHAR(64) NOT NULL,
                           type CHAR(64) NOT NULL
);

ALTER TABLE posts DROP content_type;
ALTER TABLE posts ADD content_type_id INT, ADD
FOREIGN KEY (content_type_id) REFERENCES content_type(id);
ALTER TABLE content_type ADD UNIQUE INDEX UI_type (type);
