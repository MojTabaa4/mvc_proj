use mvc_proj_db;
create table users
(
    `id`       int(11) NOT NULL auto_increment,
    `name`     varchar(50)  not null,
    `email`    varchar(255) not null,
    `password` varchar(255) not null,
    primary key (`id`),
    unique (`email`)
) engine=InnoDB default charset=utf8;