<?php

declare(strict_types=1);

// 1. sukurti connectiona prie mariaDB serverio
$config = require './config.php';
// sukuriame connectiona prie duomenu bazes

$connection = new PDO(
    sprintf('mysql:host=%s:%s', $config['host'], $config['port']),
    $config['username'],
    $config['password'],
);


// 2. istrinti egzistuojancia duomenu baze
$connection->exec('DROP DATABASE IF EXISTS ' . $config['database']);

// 3. Sukurti nauja duomenu baze
$connection->exec('CREATE DATABASE ' . $config['database']);
$connection->exec('USE ' . $config['database']);


// 4. Sukurti visas lenteles
$connection->exec('
CREATE TABLE customer
(
    id int not null PRIMARY KEY AUTO_INCREMENT,
    email varchar(255) not null,
    password_hash varchar(255) not null,
    phone_number varchar(40) not null,
    created_at datetime DEFAULT CURRENT_TIMESTAMP()
    )
');


$connection->exec('
CREATE TABLE ad
(
    id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int NOT NULL,
    CONSTRAINT FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE,
    title varchar(255) not null,
    description varchar(1000) not null,
    price int not null,
    contact_phone varchar(100),
    created_at datetime DEFAULT CURRENT_TIMESTAMP()
)
');

$connection->exec('ALTER TABLE customer ADD UNIQUE unique_customer_email (email)');

$connection->exec('
CREATE TABLE saved_ad
(
    id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int NOT NULL,
    CONSTRAINT FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE,
    ad_id int NOT NULL,
    CONSTRAINT FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE,
    created_at datetime DEFAULT CURRENT_TIMESTAMP()
)
');

echo 'Database recreated successfully!';