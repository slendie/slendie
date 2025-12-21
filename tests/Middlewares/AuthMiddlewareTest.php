<?php

use Slendie\Controllers\Middlewares\AuthMiddleware;

require_once __DIR__ . '/../../vendor/autoload.php';

it('bloqueia quando nao autenticado', function () {
  if (session_status() === PHP_SESSION_NONE) session_start();
  unset($_SESSION['user_id']);
  $mw = new AuthMiddleware();
  ob_start();
  $ok = $mw->handle(['method' => 'GET', 'path' => '/']);
  ob_end_clean();
  expect($ok)->toBeFalse();
});
