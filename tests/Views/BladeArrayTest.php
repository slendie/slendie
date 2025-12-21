<?php
it('renderiza array com chave em variavel', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html = $blade->render('test_array', ['edition' => ['date' => '2024-12-31']]);
  expect($html)->toContain('2024-12-31');
});
