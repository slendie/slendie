<?php

declare(strict_types=1);

use Slendie\Framework\Blade;

require_once __DIR__ . '/../../vendor/autoload.php';

// Define BASE_PATH se não estiver definido
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

// Função auxiliar para criar diretório temporário
function createTempViewsDir()
{
    $tempDir = sys_get_temp_dir() . '/blade_test_' . uniqid();
    mkdir($tempDir, 0777, true);
    return $tempDir;
}

it('inicializa com caminho customizado', function () {
    $tempDir = createTempViewsDir();

    $blade = new Blade($tempDir);

    expect($blade)->toBeInstanceOf(Blade::class);

    removeDirectory($tempDir);
});

it('inicializa sem caminho e usa BASE_PATH', function () {
    $blade = new Blade();

    expect($blade)->toBeInstanceOf(Blade::class);
});

it('define caminho com setPath', function () {
    $tempDir = createTempViewsDir();
    $blade = new Blade();

    $blade->setPath($tempDir);

    // Verifica se consegue renderizar um template do novo caminho
    $templateFile = $tempDir . '/test.blade.php';
    file_put_contents($templateFile, 'Hello');

    $html = $blade->render('test');
    expect($html)->toBe('Hello');

    removeDirectory($tempDir);
});

it('renderiza template simples', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/simple.blade.php';
    file_put_contents($templateFile, 'Hello World');

    $blade = new Blade($tempDir);
    $html = $blade->render('simple');

    expect($html)->toBe('Hello World');

    removeDirectory($tempDir);
});

it('renderiza variável simples', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/var.blade.php';
    file_put_contents($templateFile, 'Hello {{ $name }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('var', ['name' => 'John']);

    expect($html)->toBe('Hello John');

    removeDirectory($tempDir);
});

it('renderiza variável sem escape HTML com {{ }}', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/unescaped.blade.php';
    file_put_contents($templateFile, '{{ $content }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('unescaped', ['content' => '<strong>Bold</strong>']);

    expect($html)->toBe('<strong>Bold</strong>');

    removeDirectory($tempDir);
});

it('renderiza variável com escape HTML com {!! !!}', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/escape.blade.php';
    file_put_contents($templateFile, '{!! $content !!}');

    $blade = new Blade($tempDir);
    $html = $blade->render('escape', ['content' => '<script>alert("xss")</script>']);

    expect($html)->toContain('&lt;script&gt;');
    expect($html)->not->toContain('<script>');

    removeDirectory($tempDir);
});

it('renderiza @if simples', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if.blade.php';
    file_put_contents($templateFile, "@if(\$show)\nYes\n@else\nNo\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if', ['show' => true]);
    $html2 = $blade->render('if', ['show' => false]);

    expect($html1)->toContain('Yes');
    expect($html1)->not->toContain('No');
    expect($html2)->toContain('No');
    expect($html2)->not->toContain('Yes');

    removeDirectory($tempDir);
});

it('renderiza @if sem @else', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_no_else.blade.php';
    file_put_contents($templateFile, "@if(\$show)\nYes\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_no_else', ['show' => true]);
    $html2 = $blade->render('if_no_else', ['show' => false]);

    expect($html1)->toContain('Yes');
    expect($html2)->not->toContain('Yes');

    removeDirectory($tempDir);
});

it('renderiza @if com comparação', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_compare.blade.php';
    file_put_contents($templateFile, "@if(\$count > 5)\nHigh\n@else\nLow\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_compare', ['count' => 10]);
    $html2 = $blade->render('if_compare', ['count' => 3]);

    expect($html1)->toContain('High');
    expect($html2)->toContain('Low');

    removeDirectory($tempDir);
});

it('renderiza @if com operadores lógicos', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_logical.blade.php';
    file_put_contents($templateFile, "@if(\$a && \$b)\nBoth\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_logical', ['a' => true, 'b' => true]);
    $html2 = $blade->render('if_logical', ['a' => true, 'b' => false]);

    expect($html1)->toContain('Both');
    expect($html2)->not->toContain('Both');

    removeDirectory($tempDir);
});

it('renderiza @foreach simples', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/foreach.blade.php';
    file_put_contents($templateFile, "@foreach(\$items as \$item)\n{{ \$item }}\n@endforeach");

    $blade = new Blade($tempDir);
    $html = $blade->render('foreach', ['items' => ['a', 'b', 'c']]);

    expect($html)->toContain('a');
    expect($html)->toContain('b');
    expect($html)->toContain('c');

    removeDirectory($tempDir);
});

it('renderiza @foreach com chave e valor', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/foreach_key.blade.php';
    file_put_contents($templateFile, "@foreach(\$items as \$key => \$value)\n{{ \$key }}: {{ \$value }}\n@endforeach");

    $blade = new Blade($tempDir);
    $html = $blade->render('foreach_key', ['items' => ['name' => 'John', 'age' => 30]]);

    expect($html)->toContain('name: John');
    expect($html)->toContain('age: 30');

    removeDirectory($tempDir);
});

it('renderiza @foreach aninhado', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/foreach_nested.blade.php';
    file_put_contents($templateFile, "@foreach(\$items as \$item)\n@foreach(\$item as \$sub)\n{{ \$sub }}\n@endforeach\n@endforeach");

    $blade = new Blade($tempDir);
    $html = $blade->render('foreach_nested', ['items' => [['a', 'b'], ['c', 'd']]]);

    expect($html)->toContain('a');
    expect($html)->toContain('b');
    expect($html)->toContain('c');
    expect($html)->toContain('d');

    removeDirectory($tempDir);
});

it('renderiza @extends e @section', function () {
    $tempDir = createTempViewsDir();
    mkdir($tempDir . '/layouts', 0777, true);

    $layoutFile = $tempDir . '/layouts/app.blade.php';
    file_put_contents($layoutFile, "<html>\n<head><title>@yield('title')</title></head>\n<body>@yield('content')</body>\n</html>");

    $viewFile = $tempDir . '/page.blade.php';
    file_put_contents($viewFile, "@extends('layouts.app')\n@section('title')\nMy Page\n@endsection\n@section('content')\n<h1>Hello</h1>\n@endsection");

    $blade = new Blade($tempDir);
    $html = $blade->render('page');

    // Remove quebras de linha para comparação
    $html = str_replace(["\n", "\r"], '', $html);
    expect($html)->toContain('<title>My Page</title>');
    expect($html)->toContain('<h1>Hello</h1>');

    removeDirectory($tempDir);
});

it('renderiza @include', function () {
    $tempDir = createTempViewsDir();

    $partialFile = $tempDir . '/partials/header.blade.php';
    mkdir($tempDir . '/partials', 0777, true);
    file_put_contents($partialFile, '<header>Header</header>');

    $viewFile = $tempDir . '/page.blade.php';
    file_put_contents($viewFile, "@include('partials.header')\n<main>Content</main>");

    $blade = new Blade($tempDir);
    $html = $blade->render('page');

    expect($html)->toContain('<header>Header</header>');
    expect($html)->toContain('<main>Content</main>');

    removeDirectory($tempDir);
});

it('renderiza @csrf', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/csrf.blade.php';
    file_put_contents($templateFile, '<form>@csrf</form>');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se a classe CSRF existe
    if (class_exists('Slendie\Framework\CSRF')) {
        $blade = new Blade($tempDir);
        $html = $blade->render('csrf');

        expect($html)->toContain('_token');
        expect($html)->toContain('type="hidden"');
    } else {
        // Se CSRF não existe, apenas verifica que não quebra
        $blade = new Blade($tempDir);
        $html = $blade->render('csrf');
        expect($html)->toBeString();
    }

    removeDirectory($tempDir);
});

it('renderiza @error e @enderror', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/error.blade.php';
    file_put_contents($templateFile, "@error('email')\n{{ \$message }}\n@enderror");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['form_errors'] = ['email' => 'Email is required'];

    $blade = new Blade($tempDir);
    $html = $blade->render('error');

    // Remove quebras de linha para comparação
    $html = str_replace(["\n", "\r"], ' ', $html);
    expect($html)->toContain('Email is required');

    unset($_SESSION['form_errors']);
    removeDirectory($tempDir);
});

it('não renderiza @error quando não há erro', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/error_no_error.blade.php';
    file_put_contents($templateFile, "@error('email')\nError message\n@enderror");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['form_errors']);

    $blade = new Blade($tempDir);
    $html = $blade->render('error_no_error');

    expect($html)->not->toContain('Error message');

    removeDirectory($tempDir);
});

it('renderiza função count', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/count.blade.php';
    file_put_contents($templateFile, 'Count: {{ count($items) }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('count', ['items' => [1, 2, 3, 4, 5]]);

    expect($html)->toContain('Count: 5');

    removeDirectory($tempDir);
});

it('renderiza função array_key_exists', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/array_key.blade.php';
    file_put_contents($templateFile, "@if(array_key_exists('name', \$user))\n{{ \$user['name'] }}\n@endif");

    $blade = new Blade($tempDir);
    $html = $blade->render('array_key', ['user' => ['name' => 'John']]);

    expect($html)->toContain('John');

    removeDirectory($tempDir);
});

it('renderiza função old', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/old.blade.php';
    file_put_contents($templateFile, '<input value="{{ old(\'name\') }}">');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['old_input'] = ['name' => 'John'];

    $blade = new Blade($tempDir);
    $html = $blade->render('old');

    expect($html)->toContain('value="John"');

    unset($_SESSION['old_input']);
    removeDirectory($tempDir);
});

it('renderiza função old com valor padrão', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/old_default.blade.php';
    file_put_contents($templateFile, '<input value="{{ old(\'name\', \'Guest\') }}">');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['old_input']);

    $blade = new Blade($tempDir);
    $html = $blade->render('old_default');

    expect($html)->toContain('value="Guest"');

    removeDirectory($tempDir);
});

it('renderiza array inline', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/array_inline.blade.php';
    file_put_contents($templateFile, "@foreach([1, 2, 3] as \$num)\n{{ \$num }}\n@endforeach");

    $blade = new Blade($tempDir);
    $html = $blade->render('array_inline');

    expect($html)->toContain('1');
    expect($html)->toContain('2');
    expect($html)->toContain('3');

    removeDirectory($tempDir);
});

it('renderiza acesso a array com chave string', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/array_access.blade.php';
    file_put_contents($templateFile, "{{ \$user['name'] }}");

    $blade = new Blade($tempDir);
    $html = $blade->render('array_access', ['user' => ['name' => 'John']]);

    expect($html)->toBe('John');

    removeDirectory($tempDir);
});

it('renderiza acesso a array com índice numérico', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/array_index.blade.php';
    file_put_contents($templateFile, "{{ \$items[0] }}");

    $blade = new Blade($tempDir);
    $html = $blade->render('array_index', ['items' => ['first', 'second']]);

    expect($html)->toBe('first');

    removeDirectory($tempDir);
});

it('renderiza acesso a array aninhado', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/array_nested.blade.php';
    file_put_contents($templateFile, "{{ \$data['user']['name'] }}");

    $blade = new Blade($tempDir);
    $html = $blade->render('array_nested', ['data' => ['user' => ['name' => 'John']]]);

    expect($html)->toBe('John');

    removeDirectory($tempDir);
});

it('renderiza @if inline', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_inline.blade.php';
    file_put_contents($templateFile, '<div class="@if($new) new @endif">Item</div>');

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_inline', ['new' => true]);
    $html2 = $blade->render('if_inline', ['new' => false]);

    // Normaliza espaços para comparação
    $html1 = preg_replace('/\s+/', ' ', $html1);
    expect($html1)->toContain('new');
    expect($html2)->not->toContain('new');

    removeDirectory($tempDir);
});

it('renderiza @error inline', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/error_inline.blade.php';
    file_put_contents($templateFile, '<input class="@error(\'email\') error @enderror">');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['form_errors'] = ['email' => 'Invalid email'];

    $blade = new Blade($tempDir);
    $html = $blade->render('error_inline');

    // Normaliza espaços para comparação
    $html = preg_replace('/\s+/', ' ', $html);
    expect($html)->toContain('error');

    unset($_SESSION['form_errors']);
    removeDirectory($tempDir);
});

it('renderiza @if aninhado', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_nested.blade.php';
    file_put_contents($templateFile, "@if(\$outer)\n@if(\$inner)\nBoth\n@endif\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_nested', ['outer' => true, 'inner' => true]);
    $html2 = $blade->render('if_nested', ['outer' => true, 'inner' => false]);

    expect($html1)->toContain('Both');
    expect($html2)->not->toContain('Both');

    removeDirectory($tempDir);
});

it('renderiza @if com operador OR', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_or.blade.php';
    file_put_contents($templateFile, "@if(\$a || \$b)\nEither\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_or', ['a' => true, 'b' => false]);
    $html2 = $blade->render('if_or', ['a' => false, 'b' => false]);

    expect($html1)->toContain('Either');
    expect($html2)->not->toContain('Either');

    removeDirectory($tempDir);
});

it('renderiza @if com negação', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_not.blade.php';
    file_put_contents($templateFile, "@if(!\$hidden)\nVisible\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_not', ['hidden' => false]);
    $html2 = $blade->render('if_not', ['hidden' => true]);

    expect($html1)->toContain('Visible');
    expect($html2)->not->toContain('Visible');

    removeDirectory($tempDir);
});

it('renderiza comparação de igualdade', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/compare_eq.blade.php';
    file_put_contents($templateFile, "@if(\$status == 'active')\nActive\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('compare_eq', ['status' => 'active']);
    $html2 = $blade->render('compare_eq', ['status' => 'inactive']);

    expect($html1)->toContain('Active');
    expect($html2)->not->toContain('Active');

    removeDirectory($tempDir);
});

it('renderiza comparação de desigualdade', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/compare_neq.blade.php';
    file_put_contents($templateFile, "@if(\$status != 'active')\nNot Active\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('compare_neq', ['status' => 'inactive']);
    $html2 = $blade->render('compare_neq', ['status' => 'active']);

    expect($html1)->toContain('Not Active');
    expect($html2)->not->toContain('Not Active');

    removeDirectory($tempDir);
});

it('renderiza comparação maior que', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/compare_gt.blade.php';
    file_put_contents($templateFile, "@if(\$count > 10)\nHigh\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('compare_gt', ['count' => 15]);
    $html2 = $blade->render('compare_gt', ['count' => 5]);

    expect($html1)->toContain('High');
    expect($html2)->not->toContain('High');

    removeDirectory($tempDir);
});

it('renderiza comparação menor que', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/compare_lt.blade.php';
    file_put_contents($templateFile, "@if(\$count < 10)\nLow\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('compare_lt', ['count' => 5]);
    $html2 = $blade->render('compare_lt', ['count' => 15]);

    expect($html1)->toContain('Low');
    expect($html2)->not->toContain('Low');

    removeDirectory($tempDir);
});

it('renderiza variável com função', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/var_func.blade.php';
    file_put_contents($templateFile, '{{ strlen($text) }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('var_func', ['text' => 'Hello']);

    expect($html)->toBe('5');

    removeDirectory($tempDir);
});

it('renderiza função json_encode', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/json.blade.php';
    file_put_contents($templateFile, '{{ json_encode($data) }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('json', ['data' => ['name' => 'John', 'age' => 30]]);

    expect($html)->toContain('"name":"John"');
    expect($html)->toContain('"age":30');

    removeDirectory($tempDir);
});

it('renderiza template com dot syntax', function () {
    $tempDir = createTempViewsDir();
    mkdir($tempDir . '/layouts', 0777, true);

    $templateFile = $tempDir . '/layouts/app.blade.php';
    file_put_contents($templateFile, 'Layout: {{ $content }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('layouts.app', ['content' => 'Hello']);

    expect($html)->toContain('Layout: Hello');

    removeDirectory($tempDir);
});

it('renderiza @if com parênteses na condição', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_parens.blade.php';
    file_put_contents($templateFile, "@if((\$a && \$b) || \$c)\nMatch\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_parens', ['a' => true, 'b' => true, 'c' => false]);
    $html2 = $blade->render('if_parens', ['a' => false, 'b' => false, 'c' => true]);

    expect($html1)->toContain('Match');
    expect($html2)->toContain('Match');

    removeDirectory($tempDir);
});

it('renderiza @foreach com array inline', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/foreach_inline_array.blade.php';
    file_put_contents($templateFile, "@foreach(['a', 'b', 'c'] as \$item)\n{{ \$item }}\n@endforeach");

    $blade = new Blade($tempDir);
    $html = $blade->render('foreach_inline_array');

    expect($html)->toContain('a');
    expect($html)->toContain('b');
    expect($html)->toContain('c');

    removeDirectory($tempDir);
});

it('renderiza variável inexistente como vazio', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/var_missing.blade.php';
    file_put_contents($templateFile, 'Hello {{ $name }}');

    $blade = new Blade($tempDir);
    $html = $blade->render('var_missing');

    expect($html)->toBe('Hello ');

    removeDirectory($tempDir);
});

it('renderiza @if com variável truthy', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_truthy.blade.php';
    file_put_contents($templateFile, "@if(\$value)\nYes\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_truthy', ['value' => 'test']);
    $html2 = $blade->render('if_truthy', ['value' => '']);
    $html3 = $blade->render('if_truthy', ['value' => 0]);

    expect($html1)->toContain('Yes');
    expect($html2)->not->toContain('Yes');
    expect($html3)->not->toContain('Yes');

    removeDirectory($tempDir);
});

it('renderiza @extends sem @section', function () {
    $tempDir = createTempViewsDir();
    mkdir($tempDir . '/layouts', 0777, true);

    $layoutFile = $tempDir . '/layouts/app.blade.php';
    file_put_contents($layoutFile, '<html>@yield(\'content\')</html>');

    $viewFile = $tempDir . '/page.blade.php';
    file_put_contents($viewFile, "@extends('layouts.app')\nHello");

    $blade = new Blade($tempDir);
    $html = $blade->render('page');

    expect($html)->toContain('Hello');
    expect($html)->toContain('<html>');

    removeDirectory($tempDir);
});

it('renderiza múltiplas seções', function () {
    $tempDir = createTempViewsDir();
    mkdir($tempDir . '/layouts', 0777, true);

    $layoutFile = $tempDir . '/layouts/app.blade.php';
    file_put_contents($layoutFile, "<title>@yield('title')</title>\n@yield('content')");

    $viewFile = $tempDir . '/page.blade.php';
    file_put_contents($viewFile, "@extends('layouts.app')\n@section('title')\nMy Title\n@endsection\n@section('content')\nMy Content\n@endsection");

    $blade = new Blade($tempDir);
    $html = $blade->render('page');

    // Remove quebras de linha para comparação
    $html = str_replace(["\n", "\r"], '', $html);
    expect($html)->toContain('<title>My Title</title>');
    expect($html)->toContain('My Content');

    removeDirectory($tempDir);
});

it('renderiza @include com variáveis compartilhadas', function () {
    $tempDir = createTempViewsDir();
    mkdir($tempDir . '/partials', 0777, true);

    $partialFile = $tempDir . '/partials/header.blade.php';
    file_put_contents($partialFile, '<header>{{ $title }}</header>');

    $viewFile = $tempDir . '/page.blade.php';
    file_put_contents($viewFile, "@include('partials.header')\n<main>Content</main>");

    $blade = new Blade($tempDir);
    $html = $blade->render('page', ['title' => 'My Site']);

    expect($html)->toContain('<header>My Site</header>');

    removeDirectory($tempDir);
});

it('renderiza @error com dados do array', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/error_data.blade.php';
    file_put_contents($templateFile, "@error('email')\n{{ \$message }}\n@enderror");

    $blade = new Blade($tempDir);
    $html = $blade->render('error_data', ['form_errors' => ['email' => 'Email error']]);

    // Remove quebras de linha para comparação
    $html = str_replace(["\n", "\r"], ' ', $html);
    expect($html)->toContain('Email error');

    removeDirectory($tempDir);
});

it('renderiza @if com comparação estrita', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_strict.blade.php';
    file_put_contents($templateFile, "@if(\$value === 1)\nOne\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_strict', ['value' => 1]);
    $html2 = $blade->render('if_strict', ['value' => '1']);

    expect($html1)->toContain('One');
    expect($html2)->not->toContain('One');

    removeDirectory($tempDir);
});

it('renderiza @if com comparação de desigualdade estrita', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_strict_neq.blade.php';
    file_put_contents($templateFile, "@if(\$value !== 1)\nNot One\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_strict_neq', ['value' => 2]);
    $html2 = $blade->render('if_strict_neq', ['value' => 1]);

    expect($html1)->toContain('Not One');
    expect($html2)->not->toContain('Not One');

    removeDirectory($tempDir);
});

it('renderiza @if com comparação maior ou igual', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_gte.blade.php';
    file_put_contents($templateFile, "@if(\$count >= 10)\nAt least 10\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_gte', ['count' => 10]);
    $html2 = $blade->render('if_gte', ['count' => 15]);
    $html3 = $blade->render('if_gte', ['count' => 5]);

    expect($html1)->toContain('At least 10');
    expect($html2)->toContain('At least 10');
    expect($html3)->not->toContain('At least 10');

    removeDirectory($tempDir);
});

it('renderiza @if com comparação menor ou igual', function () {
    $tempDir = createTempViewsDir();
    $templateFile = $tempDir . '/if_lte.blade.php';
    file_put_contents($templateFile, "@if(\$count <= 10)\nAt most 10\n@endif");

    $blade = new Blade($tempDir);
    $html1 = $blade->render('if_lte', ['count' => 10]);
    $html2 = $blade->render('if_lte', ['count' => 5]);
    $html3 = $blade->render('if_lte', ['count' => 15]);

    expect($html1)->toContain('At most 10');
    expect($html2)->toContain('At most 10');
    expect($html3)->not->toContain('At most 10');

    removeDirectory($tempDir);
});
