create database projeto;

use projeto;

create table tb_usuario
(
usrId int not null primary key auto_increment,
usrLogin varchar(20) not null,
usrSenha varchar(64) not null
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

insert into TB_usuario values('1','test','test');
