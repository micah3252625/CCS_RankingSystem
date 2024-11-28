create table account
(
    id         int auto_increment
        primary key,
    user_id    int          not null,
    username   varchar(100) not null,
    password   varchar(255) not null,
    role_id    int          not null,
    created_at timestamp default CURRENT_TIMESTAMP null
);

create index role_id
    on account (role_id);

create index user_id
    on account (user_id);

create table leaderboard
(
    id             int auto_increment
        primary key,
    course         varchar(50) not null,
    semester       varchar(20) not null,
    user_id        int         not null,
    average_rating decimal(3, 2) null,
    rank_position  int null,
    created_at     timestamp default CURRENT_TIMESTAMP null
);

create index user_id
    on leaderboard (user_id);

create table rating
(
    id         int auto_increment
        primary key,
    user_id    int           not null,
    subject_id int           not null,
    semester   varchar(20)   not null,
    rating     decimal(3, 2) not null,
    adviser    varchar(100) null,
    created_at timestamp default CURRENT_TIMESTAMP null
);

create index subject_id
    on rating (subject_id);

create index user_id
    on rating (user_id);

create table role
(
    id   int auto_increment
        primary key,
    name varchar(50) not null
);

create table subject
(
    id           int auto_increment
        primary key,
    subject_code varchar(20)  not null,
    subject_name varchar(100) not null,
    created_at   timestamp default CURRENT_TIMESTAMP null
);

create table user
(
    id         int auto_increment
        primary key,
    identifier varchar(20)  not null,
    firstname  varchar(100) not null,
    middlename varchar(100) not null,
    lastname   varchar(100) not null,
    email      varchar(100) not null,
    course     varchar(50) null,
    department varchar(50) null,
    created_at timestamp default CURRENT_TIMESTAMP null
);

