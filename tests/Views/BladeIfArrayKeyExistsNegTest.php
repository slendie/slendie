<?php

declare(strict_types=1);
it('interpreta !array_key_exists', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html1 = $blade->render('test_if_array_key_exists_neg', ['team' => ['show' => 'X']]);
    expect($html1)->toContain('OK');
    $html2 = $blade->render('test_if_array_key_exists_neg', ['team' => ['dates' => ['2025-01-01']]]);
    expect($html2)->not()->toContain('OK');
});
