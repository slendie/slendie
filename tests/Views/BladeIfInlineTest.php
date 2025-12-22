<?php

declare(strict_types=1);
it('interpreta if inline', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html1 = $blade->render('test_if_inline', ['new' => true]);
    expect($html1)->toContain('Novo!');
    $html2 = $blade->render('test_if_inline', ['new' => false]);
    expect($html2)->not()->toContain('Novo!');
});
