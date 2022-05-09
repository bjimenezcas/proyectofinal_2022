CREATE TABLE invitados (
  id INT NOT NULL,
  name VARCHAR(100) NULL,
  surname VARCHAR(100) NULL,
  kids INT NULL,
  babies INT NULL,
  confirmation TINYINT NULL,
  fish_or_meat VARCHAR(45) NULL,
  PRIMARY KEY (id));

CREATE TABLE invitaciones (
  id INT NOT NULL,
  guests VARCHAR(100) NULL,
  qr_code VARCHAR(1000) NULL,
  confirmation TINYINT NULL,
  description VARCHAR(2000) NULL,
  adress VARCHAR(500) NULL,
  PRIMARY KEY (id));

ALTER TABLE invitados 
CHANGE COLUMN name name VARCHAR(100) NULL ,
CHANGE COLUMN kids kids INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN babies babies INT(11) NULL DEFAULT 0 ,
CHANGE COLUMN confirmation confirmation TINYINT(4) NULL DEFAULT 0 ;