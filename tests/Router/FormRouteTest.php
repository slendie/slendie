<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Router.php';
require_once __DIR__ . '/../../src/Request.php';
require_once __DIR__ . '/../../src/CSRF.php';

it('rota POST /contato chama App\Controllers\FormController@store', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    unset($_SESSION['old_input']);
    
    // Gera token CSRF para o teste
    $csrfToken = CSRF::token();
    
    // Simula requisição POST para /contato
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = '/contato';
    $_POST = [
        'name' => 'Teste',
        'email' => 'teste@example.com',
        'subject' => 'Teste',
        'message' => 'Mensagem de teste',
        '_token' => $csrfToken
    ];
    
    // Define as rotas
    $routes = [
        [
            'method' => 'POST',
            'path' => '/contato',
            'handler' => 'App\Controllers\FormController@store',
            'middlewares' => [],
        ]
    ];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    ob_end_clean();
    
    // Verifica se o formulário foi processado
    expect($_SESSION['form_success'])->toBe('Mensagem enviada com sucesso!');
});

it('retorna 404 para rota POST inexistente', function () {
    // Simula requisição POST para rota inexistente
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = '/rota-inexistente';
    $_POST = [];
    
    // Define rotas vazias
    $routes = [];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    // Verifica se retornou 404
    expect(http_response_code())->toBe(404);
    expect($output)->toContain('Not Found');
    
    // Reseta o código de resposta
    http_response_code(200);
});

it('não processa GET para /contato', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa a sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    
    // Simula requisição GET para /contato
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/contato';
    $_POST = [];
    
    // Define as rotas
    $routes = [
        [
            'method' => 'POST',
            'path' => '/contato',
            'handler' => 'App\Controllers\FormController@store',
            'middlewares' => [],
        ]
    ];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    // Verifica se retornou 404 (rota não encontrada para GET)
    expect(http_response_code())->toBe(404);
    expect($output)->toContain('Not Found');
    expect(isset($_SESSION['form_success']))->toBeFalse();
    
    // Reseta o código de resposta
    http_response_code(200);
});

it('rota GET /app/membro/{id}/edit passa parâmetro id para o controller', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Simula requisição GET para /app/membro/34/edit
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/app/membro/34/edit';
    $_GET = [];
    $_POST = [];
    
    // Define as rotas
    $routes = [
        [
            'method' => 'GET',
            'path' => '/app/membro/{id}/edit',
            'handler' => 'App\Controllers\MembroController@update',
            'middlewares' => [],
        ]
    ];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    // Verifica se o controller recebeu o parâmetro corretamente
    expect($output)->toContain('Editando membro com ID: 34');
});

it('rota GET /app/membro/{id} passa parâmetro id para o controller', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Simula requisição GET para /app/membro/123
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/app/membro/123';
    $_GET = [];
    $_POST = [];
    
    // Define as rotas (rota mais específica primeiro)
    $routes = [
        [
            'method' => 'GET',
            'path' => '/app/membro/{id}/edit',
            'handler' => 'App\Controllers\MembroController@update',
            'middlewares' => [],
        ],
        [
            'method' => 'GET',
            'path' => '/app/membro/{id}',
            'handler' => 'App\Controllers\MembroController@show',
            'middlewares' => [],
        ]
    ];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    // Verifica se o controller recebeu o parâmetro corretamente
    expect($output)->toContain('Exibindo membro com ID: 123');
});

it('rota com parâmetro não faz match com path diferente', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Simula requisição GET para /app/membro/34/delete (rota não existe)
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/app/membro/34/delete';
    $_GET = [];
    $_POST = [];
    
    // Define as rotas
    $routes = [
        [
            'method' => 'GET',
            'path' => '/app/membro/{id}/edit',
            'handler' => 'App\Controllers\MembroController@update',
            'middlewares' => [],
        ]
    ];
    
    // Cria o router
    $router = new Router($routes);
    
    // Captura a saída
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    // Verifica se retornou 404
    expect(http_response_code())->toBe(404);
    expect($output)->toContain('Not Found');
    
    // Reseta o código de resposta
    http_response_code(200);
});

