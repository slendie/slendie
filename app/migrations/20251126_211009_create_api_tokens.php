<?php

declare(strict_types=1);
return [
    'sqlite' => [
        "CREATE TABLE `api_tokens` (
        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          `provider` varchar(50) NOT NULL,
          `access_token` text NOT NULL,
          `refresh_token` text,
          `expires_at` datetime NOT NULL,
          `token_type` varchar(20) DEFAULT 'Bearer',
          `scope` text,
          `user_id` int DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
        );",
    ],
    'mysql' => [
        "CREATE TABLE `api_tokens` (
        `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
          `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome do provedor (aweber, mailchimp, etc)',
          `access_token` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token de acesso',
          `refresh_token` text COLLATE utf8mb4_unicode_ci COMMENT 'Token de renovação',
          `expires_at` datetime NOT NULL COMMENT 'Data de expiração do access_token',
          `token_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Bearer' COMMENT 'Tipo do token',
          `scope` text COLLATE utf8mb4_unicode_ci COMMENT 'Permissões do token',
          `user_id` int DEFAULT NULL COMMENT 'ID do usuário (opcional)',
          `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    ],
    'pgsql' => [
        "CREATE TABLE `api_tokens` (
        `id` SERIAL PRIMARY KEY NOT NULL,
          `provider` varchar(50) NOT NULL,
          `access_token` text NOT NULL,
          `refresh_token` text,
          `expires_at` datetime NOT NULL,
          `token_type` varchar(20) DEFAULT 'Bearer',
          `scope` text,
          `user_id` int DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
        );",
    ],
];
