create database projeto;

use projeto;

create table tb_usuario
(
usrId int not null primary key auto_increment,
usrLogin char(6) not null,
usrSenha char(64) not null,
usrNome varchar(50) not null,
usrEmail varchar(50) not null,
usrChave varchar(64)
);

create table tb_IP
(
ipID int not null primary key auto_increment,
ipNumero varchar(15) not null,
ipMascara int(3) not null,
ipGateway varchar(15) not null,
ipUso varchar(50)
);

create table tb_campus
(
camID int not null primary key auto_increment
);

insert into TB_usuario values('1','admin','d31a0cf48f2be3876b95d3aee8ff90f0ce3045d44386447563f48d57dfb7ed59','Admin','starwebplanning@gmail.com',NULL);