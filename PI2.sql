create database projeto;

use projeto;

create table tb_usuario
(
usrId int not null primary key auto_increment,
usrLogin char(8) not null,
usrSenha char(64) not null,
usrNome varchar(50) not null,
usrEmail varchar(50) not null,
usrChave char(64),
usrDataExpirar datetime
);