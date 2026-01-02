<?php

namespace App\Controller;

use App\Model\Log;
use App\Service\SwapiService;

class StarshipController
{
    public function listStarships() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchAllStarships();
            header('Content-Type: application/json');

            Log::save('INFO', "/starships?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $starships
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/starships?page=$page");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
    public function getStarship($id)
    {
        try {
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchStarshipById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/starships/$id");
            echo json_encode([
                'success' => true,
                'data' => $starships
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/starships/$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
}