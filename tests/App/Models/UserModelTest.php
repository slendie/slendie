<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Slendie\Framework\Database;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Define BASE_PATH se não estiver definido
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

beforeEach(function () {
    setupTestEnv();
    createTestTables();
    clearTestTables();
});

// Testes para métodos herdados do Model
it('create() insere usuário e retorna ID', function () {
    $userId = User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    expect($userId)->toBeString();
    expect((int)$userId)->toBeGreaterThan(0);
});

it('find() retorna usuário por ID', function () {
    $userId = User::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    $user = User::find($userId);

    expect($user)->not->toBeNull();
    expect((string)$user['id'])->toBe((string)$userId);
    expect($user['name'])->toBe('Jane Doe');
    expect($user['email'])->toBe('jane@example.com');
});

it('find() retorna null quando usuário não existe', function () {
    $user = User::find(99999);

    expect($user)->toBeNull();
});

it('where() encontra usuário por email', function () {
    User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    $user = User::where('email', 'test@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user['email'])->toBe('test@example.com');
});

it('all() retorna todos os usuários', function () {
    User::create([
        'name' => 'User 1',
        'email' => 'user1@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    User::create([
        'name' => 'User 2',
        'email' => 'user2@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    $users = User::all();

    expect($users)->toBeArray();
    expect($users)->toHaveCount(2);
});

it('update() atualiza dados do usuário', function () {
    $userId = User::create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    User::update($userId, [
        'name' => 'New Name',
        'email' => 'new@example.com'
    ]);

    $user = User::find($userId);

    expect($user['name'])->toBe('New Name');
    expect($user['email'])->toBe('new@example.com');
});

it('delete() remove usuário', function () {
    $userId = User::create([
        'name' => 'To Delete',
        'email' => 'delete@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    User::delete($userId);

    $user = User::find($userId);
    expect($user)->toBeNull();
});

// Testes para o método hasPermission
it('hasPermission() retorna true quando usuário tem permissão', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria permissão
    $permId = Permission::create(['name' => 'view_dashboard']);

    // Associa permissão ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $permId]);

    // Cria usuário com role
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, 'view_dashboard'))->toBeTrue();
});

it('hasPermission() retorna false quando usuário não tem permissão', function () {
    // Cria role
    $roleId = Role::create(['name' => 'user']);

    // Cria permissão
    $permId = Permission::create(['name' => 'view_dashboard']);

    // Cria usuário com role (mas sem permissão associada)
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() retorna false quando usuário não existe', function () {
    expect(User::hasPermission(99999, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() retorna false quando permissão não existe', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria usuário com role
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, 'nonexistent_permission'))->toBeFalse();
});

it('hasPermission() retorna false quando usuário não tem role', function () {
    // Cria permissão
    Permission::create(['name' => 'view_dashboard']);

    // Cria usuário sem role
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => null
    ]);

    expect(User::hasPermission($userId, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() retorna false quando role não tem permissões', function () {
    // Cria role sem permissões
    $roleId = Role::create(['name' => 'guest']);

    // Cria permissão (mas não associa ao role)
    Permission::create(['name' => 'view_dashboard']);

    // Cria usuário com role
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() funciona com múltiplas permissões', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria múltiplas permissões
    $perm1Id = Permission::create(['name' => 'view_dashboard']);
    $perm2Id = Permission::create(['name' => 'edit_users']);
    $perm3Id = Permission::create(['name' => 'delete_users']);

    // Associa todas as permissões ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $perm1Id]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $perm2Id]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $perm3Id]);

    // Cria usuário com role
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, 'view_dashboard'))->toBeTrue();
    expect(User::hasPermission($userId, 'edit_users'))->toBeTrue();
    expect(User::hasPermission($userId, 'delete_users'))->toBeTrue();
    expect(User::hasPermission($userId, 'nonexistent'))->toBeFalse();
});

it('hasPermission() diferencia permissões de diferentes roles', function () {
    // Cria dois roles
    $adminRoleId = Role::create(['name' => 'admin']);
    $userRoleId = Role::create(['name' => 'user']);

    // Cria permissões
    $adminPermId = Permission::create(['name' => 'delete_users']);
    $userPermId = Permission::create(['name' => 'view_profile']);

    // Associa permissões aos roles
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$adminRoleId, $adminPermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$userRoleId, $userPermId]);

    // Cria usuários com diferentes roles
    $adminUserId = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'hashedpassword',
        'role_id' => $adminRoleId
    ]);

    $regularUserId = User::create([
        'name' => 'Regular User',
        'email' => 'user@example.com',
        'password' => 'hashedpassword',
        'role_id' => $userRoleId
    ]);

    // Admin tem permissão de admin, mas não de user
    expect(User::hasPermission($adminUserId, 'delete_users'))->toBeTrue();
    expect(User::hasPermission($adminUserId, 'view_profile'))->toBeFalse();

    // User tem permissão de user, mas não de admin
    expect(User::hasPermission($regularUserId, 'view_profile'))->toBeTrue();
    expect(User::hasPermission($regularUserId, 'delete_users'))->toBeFalse();
});

it('hasPermission() funciona com usuários que compartilham o mesmo role', function () {
    // Cria role
    $roleId = Role::create(['name' => 'editor']);

    // Cria permissão
    $permId = Permission::create(['name' => 'edit_posts']);

    // Associa permissão ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $permId]);

    // Cria múltiplos usuários com o mesmo role
    $user1Id = User::create([
        'name' => 'Editor 1',
        'email' => 'editor1@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    $user2Id = User::create([
        'name' => 'Editor 2',
        'email' => 'editor2@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    // Ambos devem ter a mesma permissão
    expect(User::hasPermission($user1Id, 'edit_posts'))->toBeTrue();
    expect(User::hasPermission($user2Id, 'edit_posts'))->toBeTrue();
});

it('hasPermission() funciona com userId como string', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria permissão
    $permId = Permission::create(['name' => 'view_dashboard']);

    // Associa permissão ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $permId]);

    // Cria usuário
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    // Testa com userId como string
    expect(User::hasPermission((string)$userId, 'view_dashboard'))->toBeTrue();
});

it('hasPermission() funciona com userId como integer', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria permissão
    $permId = Permission::create(['name' => 'view_dashboard']);

    // Associa permissão ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $permId]);

    // Cria usuário
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    // Testa com userId como integer
    expect(User::hasPermission((int)$userId, 'view_dashboard'))->toBeTrue();
});

it('hasPermission() é case-sensitive para nomes de permissão', function () {
    // Cria role
    $roleId = Role::create(['name' => 'admin']);

    // Cria permissão com nome específico
    $permId = Permission::create(['name' => 'ViewDashboard']);

    // Associa permissão ao role
    $pdo = Database::getConnection();
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$roleId, $permId]);

    // Cria usuário
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    // Deve encontrar com o nome exato
    expect(User::hasPermission($userId, 'ViewDashboard'))->toBeTrue();

    // Não deve encontrar com nome diferente (case-sensitive)
    expect(User::hasPermission($userId, 'viewdashboard'))->toBeFalse();
    expect(User::hasPermission($userId, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() funciona com múltiplos roles e permissões complexas', function () {
    // Cria múltiplos roles
    $adminRoleId = Role::create(['name' => 'admin']);
    $moderatorRoleId = Role::create(['name' => 'moderator']);
    $editorRoleId = Role::create(['name' => 'editor']);

    // Cria múltiplas permissões
    $deletePermId = Permission::create(['name' => 'delete_posts']);
    $editPermId = Permission::create(['name' => 'edit_posts']);
    $viewPermId = Permission::create(['name' => 'view_posts']);
    $approvePermId = Permission::create(['name' => 'approve_posts']);

    // Associa permissões aos roles
    $pdo = Database::getConnection();
    // Admin tem todas as permissões
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$adminRoleId, $deletePermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$adminRoleId, $editPermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$adminRoleId, $viewPermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$adminRoleId, $approvePermId]);

    // Moderator tem approve e view
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$moderatorRoleId, $approvePermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$moderatorRoleId, $viewPermId]);

    // Editor tem edit e view
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$editorRoleId, $editPermId]);
    $pdo->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)')
        ->execute([$editorRoleId, $viewPermId]);

    // Cria usuários com diferentes roles
    $adminUserId = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => 'hashedpassword',
        'role_id' => $adminRoleId
    ]);

    $moderatorUserId = User::create([
        'name' => 'Moderator',
        'email' => 'moderator@example.com',
        'password' => 'hashedpassword',
        'role_id' => $moderatorRoleId
    ]);

    $editorUserId = User::create([
        'name' => 'Editor',
        'email' => 'editor@example.com',
        'password' => 'hashedpassword',
        'role_id' => $editorRoleId
    ]);

    // Verifica permissões do admin
    expect(User::hasPermission($adminUserId, 'delete_posts'))->toBeTrue();
    expect(User::hasPermission($adminUserId, 'edit_posts'))->toBeTrue();
    expect(User::hasPermission($adminUserId, 'view_posts'))->toBeTrue();
    expect(User::hasPermission($adminUserId, 'approve_posts'))->toBeTrue();

    // Verifica permissões do moderator
    expect(User::hasPermission($moderatorUserId, 'approve_posts'))->toBeTrue();
    expect(User::hasPermission($moderatorUserId, 'view_posts'))->toBeTrue();
    expect(User::hasPermission($moderatorUserId, 'edit_posts'))->toBeFalse();
    expect(User::hasPermission($moderatorUserId, 'delete_posts'))->toBeFalse();

    // Verifica permissões do editor
    expect(User::hasPermission($editorUserId, 'edit_posts'))->toBeTrue();
    expect(User::hasPermission($editorUserId, 'view_posts'))->toBeTrue();
    expect(User::hasPermission($editorUserId, 'approve_posts'))->toBeFalse();
    expect(User::hasPermission($editorUserId, 'delete_posts'))->toBeFalse();
});

it('hasPermission() retorna false quando userId é null', function () {
    expect(User::hasPermission(null, 'view_dashboard'))->toBeFalse();
});

it('hasPermission() retorna false quando permission é null', function () {
    $roleId = Role::create(['name' => 'admin']);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, null))->toBeFalse();
});

it('hasPermission() retorna false quando permission é string vazia', function () {
    $roleId = Role::create(['name' => 'admin']);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'hashedpassword',
        'role_id' => $roleId
    ]);

    expect(User::hasPermission($userId, ''))->toBeFalse();
});
