<?php

declare(strict_types=1);

namespace App\Controllers\Traits;

trait ApiTrait
{
    private function returnError($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'status' => 'error', 'message' => $message]);
        return '';
    }

    private function returnSuccess($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'status' => 'success', 'message' => $message]);
        return '';
    }
}
