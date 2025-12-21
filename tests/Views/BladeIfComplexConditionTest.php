<?php
it('interpreta condicao com array_key_exists, count e ||', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html1 = $blade->render('test_if_complex_cond', ['team' => ['show' => 'X']]);
  expect($html1)->toContain('NOVA EDIÇÃO!');
  $html2 = $blade->render('test_if_complex_cond', ['team' => ['dates' => ['2025-01-01', '2025-02-01']]]);
  expect($html2)->not()->toContain('NOVA EDIÇÃO!');
  $html3 = $blade->render('test_if_complex_cond', ['team' => ['dates' => []]]);
  expect($html3)->toContain('NOVA EDIÇÃO!');
});
