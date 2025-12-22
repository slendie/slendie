<?php

declare(strict_types=1);
it('interpreta < em if inline dentro de atributo', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html1 = $blade->render('test_if_inline_compare', [
        'date' => '2025-11-20',
        'today' => '2025-11-21',
    ]);
    expect($html1)->toContain('opacity-50');
    $html2 = $blade->render('test_if_inline_compare', [
        'date' => '2025-11-22',
        'today' => '2025-11-21',
    ]);
    expect($html2)->not()->toContain('opacity-50');
});
