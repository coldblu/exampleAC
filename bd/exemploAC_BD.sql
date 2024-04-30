create database exemploac;
use exemploac;

CREATE TABLE usuario (
  id int not null auto_increment,
  login varchar(45) not null unique,
  senha char(35) NOT NULL,
  primary key (id)
); 

CREATE TABLE role(
	id int not null auto_increment,
	nome varchar(100) not null unique,
	primary key(id)
);

CREATE TABLE usuario_possui_role (
	usuario_id int not null,
	role_id int not null,
	foreign key (usuario_id) references usuario (id),
	foreign key (role_id) references role (id),
	primary key(usuario_id,role_id)
	
);


CREATE TABLE funcionalidade (
	id int not null auto_increment,
	nome varchar(100) not null unique,
	primary key (id)
);


CREATE TABLE acao (
	id int not null auto_increment,
	nome varchar(100) not null unique,
	primary key(id)
);

CREATE TABLE permissao (
	usuario_id int not null,
	funcionalidade_id int not null,
	acao_id int not null,
    foreign key (funcionalidade_id) references funcionalidade (id),
    foreign key (usuario_id) references usuario (id),
	foreign key (acao_id) references acao (id),
	primary key (usuario_id,funcionalidade_id,acao_id)
);



CREATE TABLE permissao_role (
	role_id int not null,
	funcionalidade_id int not null,
	acao_id int not null,
    foreign key (funcionalidade_id) references funcionalidade (id),
    foreign key (role_id) references role (id),
	foreign key (acao_id) references acao (id),
	primary key (role_id,funcionalidade_id,acao_id)
);


INSERT INTO usuario (id, login, senha) VALUES
(1, 'cliente1', '1234'),
(2, 'cliente2', '1234'),
(3, 'vendedor1', '1234'),
(4, 'vendedor2', '1234'),
(5, 'admin', '1234');

INSERT INTO funcionalidade (id, nome) VALUES
(1, 'produtos'),
(2, 'usuários');

INSERT INTO acao (id, nome) VALUES
(1, 'incluir'),
(2, 'ler'),
(3, 'alterar'),
(4, 'excluir');

INSERT INTO role (id, nome) VALUES
(1, 'cliente'),
(2, 'vendedor'),
(3, 'admin');

INSERT INTO usuario_possui_role (usuario_id, role_id) VALUES
(1,1),
(2,1),
(3,2),
(4,2),
(5,3);


INSERT INTO permissao (usuario_id, funcionalidade_id, acao_id) VALUES
(1, 1, 2),
(2, 1, 1),
(2, 1, 2),
(3, 1, 1),
(3, 1, 2),
(4, 1, 1),
(4, 1, 2),
(4, 1, 3),
(4, 1, 4),
(5, 1, 1);


INSERT INTO permissao_role (role_id, funcionalidade_id, acao_id) VALUES
(1, 1, 2),
(2, 1, 1),
(2, 1, 2),
(2, 1, 3),
(3, 1, 1),
(3, 1, 2),
(3, 1, 3),
(3, 1, 4);

