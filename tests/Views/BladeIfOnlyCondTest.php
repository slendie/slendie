<?php
it('interpreta condicao complexa direta', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html1 = $blade->render('test_if_only_cond', ['team' => ['show' => 'X']]);
  expect($html1)->toContain('OK');
  $html2 = $blade->render('test_if_only_cond', ['team' => ['dates' => ['2025-01-01']]]);
  expect($html2)->not()->toContain('OK');
});
