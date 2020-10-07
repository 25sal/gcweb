BEGIN TRANSACTION;
DROP TABLE IF EXISTS "static";
CREATE TABLE IF NOT EXISTS "static" (
	"nodeid"	INTEGER,
	"parentid"	INTEGER NOT NULL,
	"name"	TEXT,
	"type"	INTEGER,
	PRIMARY KEY("nodeid")
);
DROP TABLE IF EXISTS "dinamicParameter";
CREATE TABLE IF NOT EXISTS "dinamicParameter" (
	"id"	integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	"idDevice"	integer,
	"key"	text,
	"val"	text
);
DROP TABLE IF EXISTS "event";
CREATE TABLE IF NOT EXISTS "event" (
	"id"	integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	"creation_time"	text,
	"idDevice"	integer,
	"type"	text
);
DROP TABLE IF EXISTS "staticParameter";
CREATE TABLE IF NOT EXISTS "staticParameter" (
	"id"	integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	"idDevice"	integer,
	"key"	text,
	"val"	text
);
DROP TABLE IF EXISTS "device";
CREATE TABLE IF NOT EXISTS "device" (
	"id"	integer,
	"id_house"	integer,
	"name"	text,
	"type"	text,
	"class"	text,
	PRIMARY KEY("id")
);
DROP TABLE IF EXISTS "housecs";
CREATE TABLE IF NOT EXISTS "housecs" (
	"id"	integer,
	PRIMARY KEY("id")
);
COMMIT;
