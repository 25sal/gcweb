create table housecs (
    id        integer primary key
);



create table device (
    id            integer primary key ,
    id_house      integer,
    name          text,
    type          text,
    class         text
);

create table staticParameter (
	id	integer primary key autoincrement not null,    
	idDevice integer,
    	key	text,
	val	text
);

create table event (
	id	integer primary key autoincrement not null,   
	creation_time text,
	idDevice	integer,
	type		text
);

create table dinamicParameter (
	id	integer primary key autoincrement not null,    
	idDevice integer,
    	key	text,
	val	text
);
