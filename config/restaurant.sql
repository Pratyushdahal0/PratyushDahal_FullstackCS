CREATE DATABASE IF NOT EXISTS restaurant_system;
USE restaurant_system;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);
