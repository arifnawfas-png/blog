PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS comment;

CREATE TABLE user (
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at VARCHAR(25) NOT NULL,
  is_enabled BOOLEAN NOT NULL DEFAULT 1
);
INSERT INTO 
 user 
  (username,password,created_at, is_enabled)
 VALUES
  ("admin,","unhashed-password",datetime('now','-3 months'), 0 )
  ;
INSERT INTO 
 user 
  (username,password,created_at, is_enabled)
 VALUES
  ("user1,","passwordtest",datetime('now','-877 days'), 0 )
  ;
INSERT INTO 
 user 
  (username,password,created_at, is_enabled)
 VALUES
  ("user2,","password123",datetime('now','+5 months'), 0 )
  ;


CREATE TABLE post (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    body TEXT NOT NULL,
    user_id TEXT NOT NULL,
    created_at VARCHAR NOT NULL,
    updated_at VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY(user_id) REFERENCES user(id)
);

INSERT INTO 
 post (title, body,user_id,created_at)
VALUES(
    "My First Post",
    "The body of the first post,
    and it is separated by multiple lines.",
    "1"
    ,DATETIME('now','-2 months', '+732 minutes')
);

INSERT INTO 
 post (title, body,user_id,created_at)
VALUES(
    "My 2nd Post",
    "The body of the second post,
    and it is separated by multiple lines.",
    "2"
    ,DATETIME('now','-40 days', '+843 minutes')
);

INSERT INTO 
 post (title, body, user_id,created_at)
VALUES(
    "My 3rd Post",
    "The body of the third post,
    and it is separated by multiple lines.",
    "3"
    ,DATETIME('now','-10 days', '-45 minutes')
);

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    post_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    nameid VARCHAR(255) NOT NULL,
    website VARCHAR(255),
    textt VARCHAR(1000) NOT NULL,
    FOREIGN KEY (post_id) REFERENCES post(id)
);

INSERT INTO 
  comment 
  (
    post_id, nameid, website, textt, created_at
  )
  VALUES (
    1,
    "Commenter1",
    "http://example.com",
    "This is a comment on the first post.",
    date("now","-10 days", '-45 minutes')
  );

INSERT INTO
  comment
    (
        post_id, nameid, website, textt, created_at
    ) 
    VALUES (
        2,
        "Commenter2",
        "http://example.com",
        "This is a comment on the second post.",
        date("now","-5 days", '-28 minutes')
    );

INSERT INTO
  comment  
    (
        post_id, nameid, website, textt, created_at
    ) 
    VALUES (
        3,
        "Commenter3",
        "http://example.com",
        "This is a comment on the third post.",
        date("now","-2 days", '+653 minutes')
    );

