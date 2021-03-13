use
mvc_proj_db
create table posts
(
    id         int(10) unsigned NOT NULL auto_increment,
    title      varchar(200) not null,
    content    text         not null,
    created_at timestamp    not null DEFAULT current_timestamp,
    primary key (id),
    key        created_at (created_at)
) engine=InnoDB DEFAULT charset=utf8;