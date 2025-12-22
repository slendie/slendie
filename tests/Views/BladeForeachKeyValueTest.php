<?php

declare(strict_types=1);
it('processa foreach com chave e valor', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_foreach_key_value', [
        'team' => [
            'dates' => ['2025-03-01', '2025-04-01']
        ]
    ]);
    expect($html)->toContain('0 - 2025-03-01');
    expect($html)->toContain('1 - 2025-04-01');
});
