<?php

declare(strict_types=1);
it('interpreta if else', function () {
    $blade = new Blade(__DIR__ . '/views');
    $html1 = $blade->render('test_if_basic', ['show' => true]);
    expect($html1)->toContain('on');
    $html2 = $blade->render('test_if_basic', ['show' => false]);
    expect($html2)->toContain('off');
});
