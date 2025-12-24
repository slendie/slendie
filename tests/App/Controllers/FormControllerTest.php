<?php

declare(strict_types=1);

use App\Controllers\FormController;
use Slendie\Framework\CSRF;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Define BASE_PATH se não estiver definido
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 3));
}

// Define PHPUNIT_TEST para ambiente de teste
if (!defined('PHPUNIT_TEST')) {
    define('PHPUNIT_TEST', true);
}

beforeEach(function () {
    clearSession();
});

it('processa formulário válido e redireciona com sucesso', function () {
    clearSession();

    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();

    // Simula dados POST válidos com token CSRF
    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste de Assunto',
        'message' => 'Esta é uma mensagem de teste.',
        '_token' => $csrfToken
    ]);

    // Cria o controller
    $controller = new FormController();

    // Executa o controller
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se a mensagem de sucesso foi definida na sessão
    expect(isset($_SESSION['form_success']))->toBeTrue();
    expect($_SESSION['form_success'])->toBe('Mensagem enviada com sucesso!');
    expect(empty($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['old_input']))->toBeFalse();

    // Em ambiente de teste, redirect retorna null
    expect($result)->toBeNull();

    restoreEnvironment($env['original']);
});

it('valida campos obrigatórios e retorna erros', function () {
    clearSession();

    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();

    // Simula dados POST vazios com token CSRF
    $env = setupRequest('POST', '/contato', [
        '_token' => $csrfToken
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se os erros foram definidos
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['name']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['subject']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['message']))->toBeTrue();
    expect(is_array($_SESSION['old_input']))->toBeTrue();

    // Verifica mensagens de erro
    expect($_SESSION['form_errors']['name'])->toBe('O nome é obrigatório.');
    expect($_SESSION['form_errors']['email'])->toBe('O e-mail é obrigatório.');
    expect($_SESSION['form_errors']['subject'])->toBe('O assunto é obrigatório.');
    expect($_SESSION['form_errors']['message'])->toBe('A mensagem é obrigatória.');

    restoreEnvironment($env['original']);
});

it('valida formato de email inválido', function () {
    clearSession();

    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();

    // Simula dados POST com email inválido e token CSRF
    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'email-invalido',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se o erro de email foi definido
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect($_SESSION['form_errors']['email'])->toBe('O e-mail informado é inválido.');
    expect(isset($_SESSION['old_input']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('preserva dados do formulário em caso de erro', function () {
    clearSession();

    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();

    // Simula dados POST parciais com token CSRF
    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        '_token' => $csrfToken
        // subject e message faltando
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se os dados foram preservados
    expect(is_array($_SESSION['old_input']))->toBeTrue();
    expect($_SESSION['old_input']['name'])->toBe('João Silva');
    expect($_SESSION['old_input']['email'])->toBe('joao@example.com');
    expect(isset($_SESSION['old_input']['subject']))->toBeFalse();
    expect(isset($_SESSION['old_input']['message']))->toBeFalse();

    restoreEnvironment($env['original']);
});

it('processa formulário completo com todos os campos válidos', function () {
    clearSession();

    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();

    // Simula dados POST completos e válidos com token CSRF
    $env = setupRequest('POST', '/contato', [
        'name' => 'Maria Santos',
        'email' => 'maria@example.com',
        'subject' => 'Consulta sobre produtos',
        'message' => 'Gostaria de obter mais informações sobre os produtos disponíveis.',
        '_token' => $csrfToken
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica sucesso sem erros
    expect($_SESSION['form_success'])->toBe('Mensagem enviada com sucesso!');
    expect(empty($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['old_input']))->toBeFalse();

    restoreEnvironment($env['original']);
});

it('valida token CSRF inválido', function () {
    clearSession();

    // Simula dados POST com token CSRF inválido
    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => 'token-invalido'
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se o erro de CSRF foi definido
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['_token']))->toBeTrue();
    expect($_SESSION['form_errors']['_token'])->toContain('Token CSRF inválido');
    expect(is_array($_SESSION['old_input']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('valida token CSRF ausente', function () {
    clearSession();

    // Simula dados POST sem token CSRF
    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste'
    ]);

    // Cria o controller
    $controller = new FormController();

    // Captura o header de redirecionamento
    ob_start();
    $result = $controller->store();
    ob_end_clean();

    // Verifica se o erro de CSRF foi definido
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['_token']))->toBeTrue();
    expect($_SESSION['form_errors']['_token'])->toContain('Token CSRF inválido');

    restoreEnvironment($env['original']);
});

it('valida nome vazio', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => '',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['name']))->toBeTrue();
    expect($_SESSION['form_errors']['name'])->toBe('O nome é obrigatório.');

    restoreEnvironment($env['original']);
});

it('valida email vazio', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => '',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect($_SESSION['form_errors']['email'])->toBe('O e-mail é obrigatório.');

    restoreEnvironment($env['original']);
});

it('valida assunto vazio', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => '',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['subject']))->toBeTrue();
    expect($_SESSION['form_errors']['subject'])->toBe('O assunto é obrigatório.');

    restoreEnvironment($env['original']);
});

it('valida mensagem vazia', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => '',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['message']))->toBeTrue();
    expect($_SESSION['form_errors']['message'])->toBe('A mensagem é obrigatória.');

    restoreEnvironment($env['original']);
});

it('valida múltiplos erros simultaneamente', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => '',
        'email' => 'email-invalido',
        'subject' => '',
        'message' => '',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['name']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['subject']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['message']))->toBeTrue();

    expect($_SESSION['form_errors']['email'])->toBe('O e-mail informado é inválido.');

    restoreEnvironment($env['original']);
});

it('preserva todos os dados em old_input quando há erros', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'email-invalido',
        'subject' => 'Teste de Assunto',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(is_array($_SESSION['old_input']))->toBeTrue();
    expect($_SESSION['old_input']['name'])->toBe('João Silva');
    expect($_SESSION['old_input']['email'])->toBe('email-invalido');
    expect($_SESSION['old_input']['subject'])->toBe('Teste de Assunto');
    expect($_SESSION['old_input']['message'])->toBe('Mensagem de teste');

    restoreEnvironment($env['original']);
});

it('limpa form_errors e old_input quando formulário é válido', function () {
    clearSession();

    // Define erros e old_input antes
    $_SESSION['form_errors'] = ['name' => 'Erro anterior'];
    $_SESSION['old_input'] = ['name' => 'Valor anterior'];

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    // Verifica que form_errors e old_input foram limpos
    expect(isset($_SESSION['form_errors']))->toBeFalse();
    expect(isset($_SESSION['old_input']))->toBeFalse();
    expect(isset($_SESSION['form_success']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('aceita email com diferentes formatos válidos', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $emails = [
        'test@example.com',
        'user.name@example.com',
        'user+tag@example.co.uk',
        'user123@example-domain.com'
    ];

    foreach ($emails as $email) {
        clearSession();

        $env = setupRequest('POST', '/contato', [
            'name' => 'João Silva',
            'email' => $email,
            'subject' => 'Teste',
            'message' => 'Mensagem de teste',
            '_token' => $csrfToken
        ]);

        $controller = new FormController();

        ob_start();
        $controller->store();
        ob_end_clean();

        expect(empty($_SESSION['form_errors']))->toBeTrue();
        expect(isset($_SESSION['form_success']))->toBeTrue();

        restoreEnvironment($env['original']);
    }
});

it('valida email com espaços em branco', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => '  joao@example.com  ',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    // Email com espaços deve ser considerado inválido pelo filter_var
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('valida campos com valores null', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => null,
        'email' => null,
        'subject' => null,
        'message' => null,
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(isset($_SESSION['form_errors']['name']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['subject']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['message']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('processa formulário com mensagem longa', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $longMessage = str_repeat('Esta é uma mensagem longa. ', 100);

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste',
        'message' => $longMessage,
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(empty($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_success']))->toBeTrue();

    restoreEnvironment($env['original']);
});

it('processa formulário com caracteres especiais', function () {
    clearSession();

    $csrfToken = CSRF::token();

    $env = setupRequest('POST', '/contato', [
        'name' => 'João Silva & Maria',
        'email' => 'joao+maria@example.com',
        'subject' => 'Teste com "aspas" e \'apóstrofes\'',
        'message' => 'Mensagem com caracteres especiais: <>&"\'',
        '_token' => $csrfToken
    ]);

    $controller = new FormController();

    ob_start();
    $controller->store();
    ob_end_clean();

    expect(empty($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_success']))->toBeTrue();

    restoreEnvironment($env['original']);
});
