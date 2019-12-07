create database projeto;

use projeto;

create table tb_campus
(
camId int not null primary key auto_increment,
camSigla char(3) not null,
camCampus varchar(30) not null,
camIP varchar(15)
) engine = InnoDB;

create table tb_usuario
(
usrId int not null primary key auto_increment,
usrLogin char(8) not null,
usrSenha char(64) not null,
usrNome varchar(50) not null,
usrEmail varchar(50) not null,
usrChave char(64),
usrDataExpirar datetime,
camId int not null,
foreign key (camId) references tb_campus(camId),
usrTipo char(1) not null
)  engine = InnoDB;

create table tb_provedor
(
proId int not null primary key auto_increment,
proNome varchar(50) not null,
proIP varchar(15) not null,
proMascara char(2) not null,
camId int not null,
foreign key (camId) references tb_campus(camId)
)  engine = InnoDB;

create table tb_ip
(
ipId int not null primary key auto_increment,
ipIP varchar(15) not null unique,
ipUso varchar(50),
proId int not null,
foreign key (proId) references tb_provedor(proId) on update cascade on delete cascade
 ) engine = InnoDB;

create table tb_vlan
(
vlanId int not null primary key,
vlanIP varchar(15) not null,
vlanDescricao varchar(50) not null,
vlanMascara char(2) not null,
vlanDHCP char(1) not null,
vlanVPN char(1) not null,
vlanCor char(7) not null,
camId int not null,
foreign key (camId) references tb_campus(camId)
)  engine = InnoDB;

create table tb_equipamento
(
equId int not null primary key auto_increment,
equMarca varchar(30) not null,
equModelo varchar(30) not null,
equTipo char(1) not null,
equQtdePorta int not null,
equLado char(1) not null,
equOrdem char(1) not null,
equDirecao char(1) not null,
equLinha int(1) not null
 ) engine = InnoDB;
 
create table tb_ativo
(
atiId int not null primary key auto_increment,
atiLocal varchar(30) not null,
atiIP varchar(15),
atiNome varchar(50) not null,
atiUsuario varchar(30) not null,
atiSenha varchar(10) not null,
equId int not null,
foreign key (equId) references tb_equipamento(equId),
camId int not null,
foreign key (camId) references tb_campus(camId)
 ) engine = InnoDB; 
 
create table tb_porta
(
porId int not null primary key auto_increment,
porNumero int(2),
porTipo int(1) default 0,
porMac char(17),
porIP varchar(15),
atiId int not null,
foreign key (atiId) references tb_ativo(atiId),
proId int,
foreign key (proId) references tb_provedor(proId),
porObs varchar(50)
)engine = InnoDB;

create table tb_porta_porta
(
porId int not null,
foreign key (porId) references tb_porta(porId),
porIdVinculada int not null,
foreign key (porIdVinculada) references tb_porta(porId)
) engine = InnoDB;
 
create table tb_porta_vlan
(
porId int not null,
foreign key (porId) references tb_porta(porId),
vlanId int not null,
foreign key (vlanId) references tb_vlan(vlanId)
)engine = InnoDB; 

insert into tb_campus values(1,'ARQ','Araraquara','');
insert into tb_campus values(2,'AVR','Avaré','');
insert into tb_campus values(3,'BRT','Barretos','');
insert into tb_campus values(4,'BRI','Birigui','');
insert into tb_campus values(5,'BTV','Boituva','');
insert into tb_campus values(6,'BRA','Bragança Paulista','');
insert into tb_campus values(7,'CMP','Campinas','');
insert into tb_campus values(8,'CJO','Campos do Jordão','');
insert into tb_campus values(9,'CPV','Capivari','');
insert into tb_campus values(10,'CGT','Caraguatatuba','');
insert into tb_campus values(11,'CTD','Catanduva','');
insert into tb_campus values(12,'CBT','Cubatão','');
insert into tb_campus values(13,'GUA','Guarulho','');
insert into tb_campus values(14,'HTO','Hortolândia','');
insert into tb_campus values(15,'IST','Ilha Solteira','');
insert into tb_campus values(16,'ITP','Itapetininga','');
insert into tb_campus values(17,'ITQ','Itaquaquecetuba','');
insert into tb_campus values(18,'JCR','Jacareí','');
insert into tb_campus values(19,'JND','Jundiaí','');
insert into tb_campus values(20,'MTO','Matão','');
insert into tb_campus values(21,'PRC','Piracicaba','');
insert into tb_campus values(22,'PTB','Pirituba','');
insert into tb_campus values(23,'PEP','Presidente Epitácio','');
insert into tb_campus values(24,'RGT','Registro','');
insert into tb_campus values(25,'SLT','Salto','');
insert into tb_campus values(26,'SCL','São Carlos','');
insert into tb_campus values(27,'SBV','São João da Boa Vista','');
insert into tb_campus values(28,'SJC','São José dos Campos','');
insert into tb_campus values(29,'SMP','São Miguel Paulista','');
insert into tb_campus values(30,'SPO','São Paulo','');
insert into tb_campus values(31,'SRQ','São Roque','');
insert into tb_campus values(32,'SRT','Sertãozinho','');
insert into tb_campus values(33,'SOR','Sorocaba','');
insert into tb_campus values(34,'SZN','Suzano','');
insert into tb_campus values(35,'TUP','Tupã','');
insert into tb_campus values(36,'VTP','Votuporanga','');

INSERT INTO `projeto`.`tb_usuario` (`usrId`, `usrLogin`, `usrSenha`, `usrNome`, `usrEmail`, `camId`, `usrTipo`) VALUES ('1', 'BA123456', '61f5be3abcd59d2d49ef1ab47bad53e227d594a60befbe6edcd260e16ae70111', 'Tiago', 'tiago@ifsp.edu.br', '3', '1');
