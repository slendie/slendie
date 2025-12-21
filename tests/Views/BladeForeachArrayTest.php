<?php
it('processa foreach com array acesso', function () {
  $blade = new Blade(__DIR__ . '/views');
  $html = $blade->render('test_foreach_array', [
    'team' => [
      'dates' => ['2025-01-01', '2025-02-01']
    ]
  ]);
  expect($html)->toContain('2025-01-01');
  expect($html)->toContain('2025-02-01');
});
