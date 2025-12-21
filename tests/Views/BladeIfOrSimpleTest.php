<?php
it('interpreta operador OR com funcao', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html = $blade->render('test_if_or_simple', ['team' => ['show' => 'X']]);
  expect($html)->toContain('YES');
});
