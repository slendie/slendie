<?php

declare(strict_types=1);
return [
    'sqlite' => [
        'CREATE TABLE IF NOT EXISTS role_permissions (role_id INTEGER NOT NULL, permission_id INTEGER NOT NULL);',
    ],
    'mysql' => [
        'CREATE TABLE IF NOT EXISTS role_permissions (role_id INT NOT NULL, permission_id INT NOT NULL);',
    ],
    'pgsql' => [
        'CREATE TABLE IF NOT EXISTS role_permissions (role_id INT NOT NULL, permission_id INT NOT NULL);',
    ],
];
