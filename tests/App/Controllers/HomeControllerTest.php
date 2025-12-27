<?php

declare(strict_types=1);

use App\Controllers\HomeController;

require_once __DIR__ . '/../../../vendor/autoload.php';

it('renderiza a home com layout', function () {
    $c = new HomeController();
    ob_start();
    $c->index();
    $out = ob_get_clean();
    expect($out)->toContain('Slendie');
    expect($out)->toContain('e Performance');
    expect($out)->toContain('Construído para desenvolvedores');
});
