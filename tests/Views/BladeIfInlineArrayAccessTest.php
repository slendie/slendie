<?php
it('interpreta if inline com acesso a array e comparacao estrita', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html1 = $blade->render('test_if_inline_array_access', ['team' => ['show' => 'Y']]);
  expect($html1)->toContain('NOVA EDIÇÃO!');
  $html2 = $blade->render('test_if_inline_array_access', ['team' => ['show' => 'N']]);
  expect($html2)->not()->toContain('NOVA EDIÇÃO!');
});
