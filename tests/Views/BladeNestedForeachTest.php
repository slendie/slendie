<?php

declare(strict_types=1);
it('processa foreach aninhado com chave e valor', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_nested_foreach', [
        'editions' => [
            ['name' => 'E1', 'dates' => ['2025-05-01', '2025-06-01']],
            ['name' => 'E2', 'dates' => ['2025-07-01']]
        ]
    ]);
    expect($html)->toContain('E1 - 0 - 2025-05-01');
    expect($html)->toContain('E1 - 1 - 2025-06-01');
    expect($html)->toContain('E2 - 0 - 2025-07-01');
});
