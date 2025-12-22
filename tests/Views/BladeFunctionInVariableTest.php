<?php

declare(strict_types=1);

it('renderiza json_encode de uma variável', function () {
    $blade = new Blade(__DIR__ . '/views');
    $data = ['name' => 'John', 'age' => 30];
    $html = $blade->render('test_function_in_variable', ['data' => $data]);
    $expected = json_encode($data);
    expect($html)->toContain($expected);
});

it('renderiza json_encode com JSON_PRETTY_PRINT', function () {
    $blade = new Blade(__DIR__ . '/views');
    $data = ['name' => 'John', 'age' => 30];
    $html = $blade->render('test_function_in_variable_pretty', ['data' => $data]);
    $expected = json_encode($data, JSON_PRETTY_PRINT);
    expect($html)->toContain($expected);
});

it('renderiza strlen de uma string', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_function_strlen', ['text' => 'Hello World']);
    expect($html)->toContain('11');
});

it('renderiza htmlspecialchars de uma string', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_function_htmlspecialchars', ['content' => '<script>alert("xss")</script>']);
    expect($html)->toContain('&lt;script&gt;');
    expect($html)->not->toContain('<script>');
});

it('renderiza função com múltiplos argumentos', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_function_multiple_args', ['text' => 'Hello']);
    expect($html)->toContain('HELLO');
});

it('renderiza função count dentro de variável', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_function_count', ['items' => [1, 2, 3, 4, 5]]);
    expect($html)->toContain('5');
});

it('renderiza função com constante como argumento', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_function_with_constant', ['text' => 'café']);
    $expected = json_encode('café', JSON_UNESCAPED_UNICODE);
    expect($html)->toContain($expected);
});
