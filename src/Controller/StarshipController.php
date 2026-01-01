<?php

namespace App\Controller;

use App\Service\SwapiService;

class StarshipController
{
    public function listStarships() {
        try {
            $swapiService = new SwapiService();
            $starships = $swapiService->fetchAllStarships();
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $starships
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
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
            echo json_encode([
                'success' => true,
                'data' => $starships
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch starships'
            ], 500);
        }
    }
}