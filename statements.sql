DROP DATABASE IF EXISTS tennis;

CREATE DATABASE tennis;

USE tennis;

CREATE TABLE toernooi(
    id int not null AUTO_INCREMENT,
    omschrijving varchar(255) not null,
    datum date not null,
    primary key(id)
);

CREATE TABLE school(
    id int not null AUTO_INCREMENT,
    naam varchar(255) not null unique,
    primary key(id)
);

CREATE TABLE speler(
    id int not null AUTO_INCREMENT,
    roepnaam varchar(255) not null,
    tussenvoegsel varchar(255) not null,
    achternaam varchar(255) not null,
    schoolID int not null,
    neemtdeel boolean not null,
    primary key(id),
    foreign key(schoolID) references school(id) ON DELETE CASCADE
);

CREATE TABLE aanmelding(
    id int not null AUTO_INCREMENT,
    spelerID int not null,
    toernooiID int not null,
    primary key(id),
    foreign key(spelerID) references speler(id) ON DELETE CASCADE,
    foreign key(toernooiID) references toernooi(id) ON DELETE CASCADE
);


CREATE TABLE wedstrijd(
    id int not null AUTO_INCREMENT,
    toernooiID int not null,
    ronde smallint not null,
    speler1 int not null,
    speler2 int not null,
    score1 int,
    score2 int,
    winnaarID int,
    primary key(id),
    foreign key(toernooiID) references toernooi(id) ON DELETE CASCADE,
    foreign key(speler1) references speler(id) ON DELETE CASCADE,
    foreign key(speler2) references speler(id) ON DELETE CASCADE,
    foreign key(winnaarID) references speler(id) ON DELETE CASCADE
);