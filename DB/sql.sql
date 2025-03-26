CREATE DATABASE user_system;

USE user_system;

CREATE TABLE users (
    sno INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gmail VARCHAR(100) UNIQUE NOT NULL,
    usernameid VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    joindate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    token VARCHAR(255) NOT NULL DEFAULT 'NULL',
    role ENUM('user', 'admin') DEFAULT 'user'
);
