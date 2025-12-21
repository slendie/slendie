<?php

use App\Controllers\FormController;
use Slendie\Controllers\Middlewares\WebMiddleware;
use Slendie\Framework\CSRF;
use Slendie\Framework\Request;

require_once __DIR__ . '/../../vendor/autoload.php';

it('processa formulário válido e redireciona com sucesso', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula dados POST válidos com token CSRF
    $_POST = [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'subject' => 'Teste de Assunto',
        'message' => 'Esta é uma mensagem de teste.',
        '_token' => $csrfToken
    ];
    
    // Cria uma instância de Request
    $request = new Request();
    
    // Injeta a Request no Slendie\Controllers\Middlewares\WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);
    
    // Cria o controller
    $controller = new FormController();
    
    // Executa o controller
    ob_start();
    try {
        $controller->store();
    } catch (Exception $e) {
        // Ignora exceções de header já enviado em testes
    }
    ob_end_clean();
    
    // Verifica se a mensagem de sucesso foi definida na sessão
    expect(isset($_SESSION['form_success']))->toBeTrue();
    expect($_SESSION['form_success'])->toBe('Mensagem enviada com sucesso!');
    expect(empty($_SESSION['form_errors']))->toBeTrue();
});

it('valida campos obrigatórios e retorna erros', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula dados POST vazios com token CSRF
    $_POST = [
        '_token' => $csrfToken
    ];
    
    // Cria uma instância de Request
    $request = new Request();
    
    // Injeta a Request no Slendie\Controllers\Middlewares\WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);
    
    // Cria o controller
    $controller = new FormController();
    
    // Captura o header de redirecionamento
    ob_start();
    $controller->store();
    ob_end_clean();
    
    // Verifica se os erros foram definidos
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['name']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['subject']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['message']))->toBeTrue();
    expect(is_array($_SESSION['old_input']))->toBeTrue();
});

it('valida formato de email inválido', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula dados POST com email inválido e token CSRF
    $_POST = [
        'name' => 'João Silva',
        'email' => 'email-invalido',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ];
    
    // Cria uma instância de Request
    $request = new Request();
    
    // Injeta a Request no Slendie\Controllers\Middlewares\WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);
    
    // Cria o controller
    $controller = new FormController();
    
    // Captura o header de redirecionamento
    ob_start();
    $controller->store();
    ob_end_clean();
    
    // Verifica se o erro de email foi definido
    expect(is_array($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['form_errors']['email']))->toBeTrue();
    expect($_SESSION['form_errors']['email'])->toContain('inválido');
});

it('preserva dados do formulário em caso de erro', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula dados POST parciais com token CSRF
    $_POST = [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        '_token' => $csrfToken
        // subject e message faltando
    ];
    
    // Cria uma instância de Request
    $request = new Request();
    
    // Injeta a Request no Slendie\Controllers\Middlewares\WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);
    
    // Cria o controller
    $controller = new FormController();
    
    // Captura o header de redirecionamento
    ob_start();
    $controller->store();
    ob_end_clean();
    
    // Verifica se os dados foram preservados
    expect(is_array($_SESSION['old_input']))->toBeTrue();
    expect($_SESSION['old_input']['name'])->toBe('João Silva');
    expect($_SESSION['old_input']['email'])->toBe('joao@example.com');
});

it('processa formulário completo com todos os campos válidos', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula dados POST completos e válidos com token CSRF
    $_POST = [
        'name' => 'Maria Santos',
        'email' => 'maria@example.com',
        'subject' => 'Consulta sobre produtos',
        'message' => 'Gostaria de obter mais informações sobre os produtos disponíveis.',
        '_token' => $csrfToken
    ];
    
    // Cria uma instância de Request
    $request = new Request();
    
    // Injeta a Request no Slendie\Controllers\Middlewares\WebMiddleware
    $webMiddleware = new WebMiddleware();
    $webMiddleware->handle($request);
    
    // Cria o controller
    $controller = new FormController();
    
    // Captura o header de redirecionamento
    ob_start();
    $controller->store();
    ob_end_clean();
    
    // Verifica sucesso sem erros
    expect($_SESSION['form_success'])->toBe('Mensagem enviada com sucesso!');
    expect(empty($_SESSION['form_errors']))->toBeTrue();
    expect(isset($_SESSION['old_input']))->toBeFalse();
});

