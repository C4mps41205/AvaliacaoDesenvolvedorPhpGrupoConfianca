create database if not exists `grupo-confianca-db`;
use `grupo-confianca-db`;

create table state
(
    id int not null auto_increment primary key,
    nameState varchar(50),
    uf char(2)
);

insert into state (nameState, uf) VALUES ('Acre', 'AC'),
									('Alagoas', 'AL'),
                                    ('Amapá', 'AP'),
                                    ('Amazonas', 'AM'),
                                    ('Bahia', 'BA'),
									('Ceará', 'CE'),
                                    ('Distrito Federal','DF'),
                                    ('Espírito Santo', 'ES'),
                                    ('Goiás', 'GO'),
                                    ('Maranhão', 'MA'),
                                    ('Mato Grosso', 'MT'),
                                    ('Mato Grosso do Sul','MS'),
                                    ('Minas Gerais','MG'),
                                    ('Pará','PA'),
                                    ('Paraíba','PB'),
                                    ('Paraná','PR'),
                                    ('Pernambuco', 'PE'),
                                    ('Piauí','PI'),
                                    ('Rio de Janeiro', 'RJ'),
                                    ('Rio Grande do Norte', 'RN'),
                                    ('Rio Grande do Sul','RS'),
                                    ('Rondônia','RO'),
                                    ('Roraima','RR'),
                                    ('Santa Catarina','SC'),
                                    ('Sergipe','SE'),
                                    ('São paulo','SP'),
                                    ('Tocantins','TO');

CREATE TABLE client_register
(
    idClient int not null auto_increment primary key,
    name varchar(50) not null,
    itr char(14) not null,
    birthdate varchar(10) not null,
    state int not null,
    city varchar(50),
    neighborhood varchar(100),
    phone char(14),
    email varchar(100),

    foreign key (state) references state(id)
);

insert into client_register (name, itr, birthdate, state, city, neighborhood, phone, email) values ('Lucas José Campos Pacheco', 
																									'123.456.789-10', '04/12/2005', 
                                                                                                    13, 
                                                                                                    'Belo Horizonte', 
                                                                                                    'Jardim América', 
                                                                                                    '(31)99229-4402', 
                                                                                                    'lucasjcpacheco2005@gmail.com');
