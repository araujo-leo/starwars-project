<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;

class ErrorController
{
    private function isAjaxRequest(): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        return strpos($uri, '/api') === 0;
    }

    public function notFound(): string
    {
        if($this->isAjaxRequest()) {
            http_response_code(404);
            header('Content-Type: application/json');
            Log::save('WARNING', $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], 404);
            echo json_encode([
                'sucess' => false,
                'error'  => 'Resource not found'
            ], 404);
            exit;
        }
        http_response_code(404);
        return View::render('errors/404');
    }

    public function internalServerError(\Throwable $e): string
    {
        if($this->isAjaxRequest()) {
            http_response_code(500);
            header('Content-Type: application/json');
            Log::save('ERROR', $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], 500);
            echo json_encode([
                'sucess' => false,
                'error'  => 'Internal server error'
            ], 500);
            exit;
        }

        if ($e) {
            error_log($e->getMessage());
        }

        http_response_code(500);
        return View::render('errors/500', ['error' => $e ? $e->getMessage() : 'Unknown error']);
    }
}