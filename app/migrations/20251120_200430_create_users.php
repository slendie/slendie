<?php
return [
  'sqlite' => [
    'CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL, role_id INTEGER);',
  ],
  'mysql' => [
    'CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, role_id INT NULL);',
  ],
  'pgsql' => [
    'CREATE TABLE IF NOT EXISTS users (id SERIAL PRIMARY KEY, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL, role_id INT NULL);',
  ],
];
