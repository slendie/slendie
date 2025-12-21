<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Slendie\Framework\Database;

require_once __DIR__ . '/../../vendor/autoload.php';

it('verifica permissao de utilizador', function () {
  $pdo = Database::getConnection();
  $m = require __DIR__ . '/../../app/migrations/create_users.php';
  foreach ($m['sqlite'] as $sql) { $pdo->exec($sql); }
  $roleId = Role::create(['name' => 'admin']);
  $permId = Permission::create(['name' => 'view_dashboard']);
  $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')->execute([$roleId, $permId]);
  $userId = User::create(['name' => 'Test', 'email' => 't@example.com', 'password' => 'x', 'role_id' => $roleId]);
  $_SESSION['user_id'] = $userId;
  expect(User::hasPermission($userId, 'view_dashboard'))->toBeTrue();
});
