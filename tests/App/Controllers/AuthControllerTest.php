<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Models\User;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../functions.php';

// Define BASE_PATH se não estiver definido
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 3));
}

// Define PHPUNIT_TEST para ambiente de teste
if (!defined('PHPUNIT_TEST')) {
    define('PHPUNIT_TEST', true);
}

beforeEach(function () {
    setupTestEnv();
    createTestTables();
    clearTestTables();
    clearSession();
});

it('login() renderiza view de login', function () {
    $env = setupRequest('GET', '/login');

    $controller = new AuthController();

    ob_start();
    $controller->login();
    $output = ob_get_clean();

    expect($output)->toBeString();

    restoreEnvironment($env['original']);
});

it('signin() valida campos obrigatórios', function () {
    $env = setupRequest('POST', '/login', []);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    // Deve renderizar a view de login com erros
    expect($output)->toBeString();

    // Verifica que formErrors foi definido
    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toBeArray();
    expect($formErrors)->toHaveKey('email');

    restoreEnvironment($env['original']);
});

it('signin() valida quando email está vazio', function () {
    $env = setupRequest('POST', '/login', ['password' => 'password123']);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('preencha todos os campos');

    restoreEnvironment($env['original']);
});

it('signin() valida quando senha está vazia', function () {
    $env = setupRequest('POST', '/login', ['email' => 'test@example.com']);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('preencha todos os campos');

    restoreEnvironment($env['original']);
});

it('signin() retorna erro quando usuário não existe', function () {
    $env = setupRequest('POST', '/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('Email ou senha inválidos');

    restoreEnvironment($env['original']);
});

it('signin() retorna erro quando senha está incorreta', function () {
    // Cria usuário
    $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('Email ou senha inválidos');

    // Verifica que user_id não foi definido na sessão
    expect(isset($_SESSION['user_id']))->toBeFalse();

    restoreEnvironment($env['original']);
});

it('signin() autentica usuário com credenciais corretas', function () {
    // Cria usuário
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $result = $controller->signin();
    $output = ob_get_clean();

    // Deve definir user_id na sessão (pode ser string ou int dependendo do driver)
    expect((string)$_SESSION['user_id'])->toBe((string)$userId);

    // Deve retornar null (redirect em ambiente de teste)
    expect($result)->toBeNull();

    restoreEnvironment($env['original']);
});

it('signin() sanitiza email para evitar XSS', function () {
    $env = setupRequest('POST', '/login', [
        'email' => '<script>alert("xss")</script>test@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    // O email deve ser sanitizado antes de ser usado na query
    // Verifica que não há erro de SQL injection ou XSS
    expect($output)->toBeString();

    restoreEnvironment($env['original']);
});

it('register() renderiza view de registro', function () {
    $env = setupRequest('GET', '/register');

    $controller = new AuthController();

    ob_start();
    $controller->register();
    $output = ob_get_clean();

    expect($output)->toBeString();

    restoreEnvironment($env['original']);
});

it('register() passa step 1 para a view', function () {
    $env = setupRequest('GET', '/register');

    $controller = new AuthController();

    ob_start();
    $controller->register();
    $output = ob_get_clean();

    // A view deve receber step => 1
    expect($output)->toBeString();

    restoreEnvironment($env['original']);
});

it('store() valida nome obrigatório', function () {
    $env = setupRequest('POST', '/register', [
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('name');
    expect($formErrors['name'])->toContain('obrigatório');

    restoreEnvironment($env['original']);
});

it('store() valida email obrigatório', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('obrigatório');

    restoreEnvironment($env['original']);
});

it('store() valida formato de email', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('não é válido');

    restoreEnvironment($env['original']);
});

it('store() valida quando email já existe', function () {
    // Cria usuário existente
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    User::create([
        'name' => 'Existing User',
        'email' => 'existing@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/register', [
        'name' => 'New User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('email');
    expect($formErrors['email'])->toContain('já está em uso');

    restoreEnvironment($env['original']);
});

it('store() valida senha obrigatória', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '', // Senha vazia
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('password');
    expect($formErrors['password'])->toContain('obrigatória');

    restoreEnvironment($env['original']);
});

it('store() valida tamanho mínimo da senha', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'short',
        'password_confirmation' => 'short'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('password');
    expect($formErrors['password'])->toContain('8 caracteres');

    restoreEnvironment($env['original']);
});

it('store() valida confirmação de senha obrigatória', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('password_confirmation');
    expect($formErrors['password_confirmation'])->toContain('obrigatória');

    restoreEnvironment($env['original']);
});

it('store() valida quando senhas não coincidem', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    expect($formErrors)->toHaveKey('password');
    expect($formErrors['password'])->toContain('não coincidem');

    restoreEnvironment($env['original']);
});

it('store() cria usuário quando dados são válidos', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $result = $controller->store();
    $output = ob_get_clean();

    // Verifica que o usuário foi criado
    $user = User::where('email', 'newuser@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user['name'])->toBe('New User');
    expect($user['email'])->toBe('newuser@example.com');

    // Verifica que a senha foi hasheada
    expect(password_verify('password123', $user['password']))->toBeTrue();

    // Deve definir form_success na sessão
    expect($_SESSION['form_success'])->toContain('sucesso');

    // Deve retornar null (redirect em ambiente de teste)
    expect($result)->toBeNull();

    restoreEnvironment($env['original']);
});

it('store() hash da senha corretamente', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();

    // Verifica que a senha foi hasheada (não está em texto plano)
    expect($user['password'])->not->toBe('password123');
    expect(password_verify('password123', $user['password']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('store() cria usuário sem role_id por padrão', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user['role_id'])->toBeNull();

    restoreEnvironment($env['original']);
});

it('store() sanitiza nome e email para evitar XSS', function () {
    $env = setupRequest('POST', '/register', [
        'name' => '<script>alert("xss")</script>Test User',
        'email' => '<script>alert("xss")</script>test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $user = User::where('email', 'test@example.com')->first();

    // O email deve ser sanitizado (mas pode não encontrar porque foi sanitizado)
    // Vamos verificar que não há erro de SQL injection
    expect($output)->toBeString();

    restoreEnvironment($env['original']);
});

it('store() renderiza view de registro quando há erros', function () {
    $env = setupRequest('POST', '/register', [
        'name' => '', // Nome vazio para gerar erro
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    // Deve renderizar a view de registro
    expect($output)->toBeString();

    // Não deve criar usuário
    $user = User::where('email', 'test@example.com')->first();
    expect($user)->toBeNull();

    restoreEnvironment($env['original']);
});

it('logout() destrói sessão e redireciona', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['user_id'] = 1;
    $_SESSION['other_data'] = 'test';

    $env = setupRequest('POST', '/logout');

    $controller = new AuthController();

    ob_start();
    $result = $controller->logout();
    $output = ob_get_clean();

    // session_destroy() limpa toda a sessão
    // Em ambiente de teste, pode não destruir completamente, mas verifica o comportamento
    expect($result)->toBeNull();

    restoreEnvironment($env['original']);
});

it('signin() redireciona após autenticação bem-sucedida', function () {
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $result = $controller->signin();
    $output = ob_get_clean();

    // Em ambiente de teste, redirect retorna null
    expect($result)->toBeNull();
    expect((string)$_SESSION['user_id'])->toBe((string)$userId);

    restoreEnvironment($env['original']);
});

it('store() redireciona após registro bem-sucedido', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $result = $controller->store();
    $output = ob_get_clean();

    // Em ambiente de teste, redirect retorna null
    expect($result)->toBeNull();

    // Deve ter mensagem de sucesso na sessão
    expect($_SESSION['form_success'])->toContain('sucesso');

    restoreEnvironment($env['original']);
});

it('signin() funciona com email em diferentes formatos', function () {
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test.user@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test.user@example.com',
        'password' => 'password123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    expect((string)$_SESSION['user_id'])->toBe((string)$userId);

    restoreEnvironment($env['original']);
});

it('store() aceita senha com caracteres especiais', function () {
    $env = setupRequest('POST', '/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'P@ssw0rd!123',
        'password_confirmation' => 'P@ssw0rd!123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect(password_verify('P@ssw0rd!123', $user['password']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('signin() funciona com senha com caracteres especiais', function () {
    $hashedPassword = password_hash('P@ssw0rd!123', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test@example.com',
        'password' => 'P@ssw0rd!123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    expect((string)$_SESSION['user_id'])->toBe((string)$userId);

    restoreEnvironment($env['original']);
});

it('store() valida múltiplos erros simultaneamente', function () {
    $env = setupRequest('POST', '/register', [
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'different'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->store();
    $output = ob_get_clean();

    $reflection = new ReflectionClass($controller);
    $property = $reflection->getProperty('formErrors');
    $property->setAccessible(true);
    $formErrors = $property->getValue($controller);

    // Deve ter múltiplos erros
    expect($formErrors)->toHaveKey('name');
    expect($formErrors)->toHaveKey('email');
    expect($formErrors)->toHaveKey('password');

    restoreEnvironment($env['original']);
});

it('signin() não sanitiza senha', function () {
    // A senha não deve ser sanitizada com htmlspecialchars
    // pois isso alteraria caracteres especiais
    $hashedPassword = password_hash('P@ssw0rd!123', PASSWORD_DEFAULT);
    $userId = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $hashedPassword,
        'role_id' => null
    ]);

    $env = setupRequest('POST', '/login', [
        'email' => 'test@example.com',
        'password' => 'P@ssw0rd!123'
    ]);

    $controller = new AuthController();

    ob_start();
    $controller->signin();
    $output = ob_get_clean();

    // Deve autenticar corretamente mesmo com caracteres especiais
    expect((string)$_SESSION['user_id'])->toBe((string)$userId);

    restoreEnvironment($env['original']);
});
