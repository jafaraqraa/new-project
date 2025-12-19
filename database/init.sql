-- database/init.sql

CREATE DATABASE IF NOT EXISTS restaurant_app
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE restaurant_app;

CREATE TABLE IF NOT EXISTS restaurants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  meal_type VARCHAR(50) NOT NULL,
  rating DECIMAL(3,2) NOT NULL DEFAULT 0.00
);

TRUNCATE TABLE restaurants;

INSERT INTO restaurants (name, meal_type, rating) VALUES
('Shawarma King', 'shawarma', 4.70),
('AlQuds Grill',  'shawarma', 4.40),
('Pizza House',   'pizza',    4.60),
('Napoli Pizza',  'pizza',    4.20),
('Burger Lab',    'burger',   4.80),
('Classic Burger','burger',   4.30),
('Sushi Corner',  'sushi',    4.50),
('Green Salad',   'salad',    4.10);
