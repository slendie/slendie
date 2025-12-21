<?php
it('interpreta variavel de indice em array multidimensional', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html = $blade->render('test_array_index_var', [
    'team' => [
      'dates' => [0 => '2025-01-01', 1 => '2025-02-01'],
      'long_date' => [
        0 => '01 Janeiro 2025',
        1 => '01 Fevereiro 2025'
      ]
    ]
  ]);
  expect($html)->toContain('01 Janeiro 2025');
  expect($html)->toContain('01 Fevereiro 2025');
});
