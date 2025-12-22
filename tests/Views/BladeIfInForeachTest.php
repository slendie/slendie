<?php

declare(strict_types=1);
it('interpreta if dentro de foreach', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html = $blade->render('test_if_in_foreach', [
        'items' => ['a', 'b']
    ]);
    expect($html)->toContain('A');
    expect($html)->toContain('X');
});
