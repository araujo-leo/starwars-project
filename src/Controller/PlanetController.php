<?php

namespace App\Controller;

use App\Model\Log;
use App\Service\SwapiService;

class PlanetController
{
    public function listPlanets() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $planets = $swapiService->fetchAllPlanets();
            header('Content-Type: application/json');

            Log::save('INFO', "/films?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $planets
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/planets" );
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch planets'
            ], 500);
        }
    }
    public function getPlanet($id)
    {
        try {
            $swapiService = new SwapiService();
            $planets = $swapiService->fetchPlanetById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/planets/$id");
            echo json_encode([
                'success' => true,
                'data' => $planets
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/planets");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch planets'
            ], 500);
        }
    }
}