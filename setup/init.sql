USE blog;

CREATE TABLE authors (
  email VARCHAR(128) NOT NULL PRIMARY KEY,
  passwd_hash VARCHAR(255) NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  middle_name VARCHAR(50) NULL DEFAULT NULL,
  last_name VARCHAR(50) NULL DEFAULT NULL,
  display_name VARCHAR(50) NULL DEFAULT NULL,
  mobile VARCHAR(15) NULL,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  intro TINYTEXT NOT NULL,
  profile TEXT NULL DEFAULT NULL
);

INSERT INTO `authors`(`email`, 
                    `passwd_hash`, 
                    `first_name`, 
                    `middle_name`, 
                    `last_name`, 
                    `display_name`, 
                    `mobile`, 
                    `intro`, 
                    `profile`)
 VALUES ("gihanmadurangasl@gmail.com",
        "*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19",
        "Gihan",
        "Maduranga",
        "Gat",
        "GMad",
        "653356346",
        "test site intro",
        "test site bio")