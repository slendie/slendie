<?php
return [
  'sqlite' => [
    'CREATE TABLE IF NOT EXISTS permissions (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL UNIQUE);',
  ],
  'mysql' => [
    'CREATE TABLE IF NOT EXISTS permissions (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL UNIQUE);',
  ],
  'pgsql' => [
    'CREATE TABLE IF NOT EXISTS permissions (id SERIAL PRIMARY KEY, name TEXT NOT NULL UNIQUE);',
  ],
];
