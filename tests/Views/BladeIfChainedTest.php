<?php

declare(strict_types=1);
it('interpreta ifs encadeados com estrita e solta igualdade', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_if_chained', [
        'test' => 'local',
        'mode' => 'test'
    ]);
    expect($html)->toContain('OK');
    $html2 = $blade->render('test_if_chained', [
        'test' => 'local',
        'mode' => 'prod'
    ]);
    expect($html2)->not()->toContain('OK');
});
