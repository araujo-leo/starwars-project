<?php
namespace App\Controller;

use App\Service\SwapiService;
use App\Config\Database;
use Exception;

class FilmController {
    public function listFilms() {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchAllFilms();
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $films
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch films'
            ], 500);
        }
    }
}