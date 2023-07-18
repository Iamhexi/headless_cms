<?php
require '../Configuration.php';

$tokenLength = Configuration::TEMPORARY_ACCESS_TOKEN_LENGTH;
$sqlQueries = "create database headless_cms;";
$sqlQueries .= "
        create table people (
            id int auto_increment primary key,
            first_name varchar(50),
            last_name varchar(50),
            serialized_role varbinary(255) not null,
            hashed_personal_access_token char($tokenLength) not null,
            last_active_time bigint default 0
        );
    ";
$sqlQueries .= "
        create table articles (
            id int auto_increment primary key,
            serialized_object varbinary(255) not null
        );
    ";
$sqlQueries .= "
        create table temporary_access_tokens (
            person_id int not null,
            token char($tokenLength) not null,
            expire_time bigint default 0 
        );
    ";



file_put_contents('install.sql', $sqlQueries);