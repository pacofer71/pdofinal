-- Tablas para pdofinal
-- Tabla Usuarios
-- ------------------------
drop table if exists usuarios;
drop table if exists relacion;
drop table if exists plataformas;
drop table if exists juegos;
-- -------------------
create table usuarios(
	nombre varchar(20) primary key,
	pass varchar(255) not null,
	perfil enum('Admin', 'Normal') not null,
	email varchar(40) unique not null
);
-- Tabla Plataformas
create table plataformas(
	id int auto_increment primary key,
	nombre varchar(60) not null,
	imagen varchar(120) default 'img/plataformas/default.jpg' 
);
-- Table videjuegos
create table videojuegos(
	id int auto_increment primary key,
	nombre varchar(80) not null,
	fecha date default '2000/01/01',
	sinopsis text,
	pegi int,
	formato enum('Digital', 'Fisico'),
	imagen varchar(120) default 'img/videojuegos/default.jpg'
);
create table relacion(
	id_juego int,
	id_pla int,
	constraint pk_relacion primary key(id_pla, id_juego),
	constraint fk_rel1 foreign key(id_pla) references plataformas(id) on delete cascade,
	constraint fk_rel2 foreign key(id_juego) references videojuegos(id) on delete cascade
);
-- Datos
insert into usuarios values('admin', sha2('secreto', 224), 1, 'admin@email.com');
insert into usuarios values('pedro', sha2('secreto', 224), 2, 'pedro@email.com');
-- ---------------
insert into plataformas(nombre) values('PS3');
insert into plataformas(nombre) values('PS4');
insert into plataformas(nombre) values('XBOX 360');
insert into plataformas(nombre) values('XBOX ONE');
insert into plataformas(nombre) values('PC');
insert into plataformas(nombre) values('NINTENDO SWITCH');
insert into plataformas(nombre) values('NINTENDO WII');
insert into plataformas(nombre) values('NINTENDO WII-U');
-- ------------------------------
insert into videojuegos(nombre,pegi, formato, sinopsis) values('FORNITE', 12, 1, 'Un Juego Muy Entretenido y Didáctico');
insert into videojuegos(nombre,pegi, formato, sinopsis) values('APEX', 12, 1, 'Un Juego Muy Entretenido y Didáctico');
insert into videojuegos(nombre,pegi, formato, sinopsis) values('THE DIVISION 2', 18, 2, 'Un Juego Muy Entretenido y Didáctico');
insert into videojuegos(nombre,pegi, formato, sinopsis) values('CALL OF DUTY GHOST', 18, 1, 'Un Juego Muy Entretenido y Didáctico');
insert into videojuegos(nombre,pegi, formato, sinopsis) values('MINECRAFT', 6, 1, 'Un Juego Muy Entretenido y Didáctico');
-- -----------------------------
INSERT INTO relacion values(1, 1);
INSERT INTO relacion values(1, 2);
INSERT INTO relacion values(1, 3);
INSERT INTO relacion values(2, 4);
INSERT INTO relacion values(2, 5);
INSERT INTO relacion values(2, 6);
INSERT INTO relacion values(3, 7);
INSERT INTO relacion values(4, 8);
INSERT INTO relacion values(5, 8);
INSERT INTO relacion values(1, 7);
INSERT INTO relacion values(2, 1);
INSERT INTO relacion values(3, 5);


