<?php

namespace App\Controller;

use App\Service\SwapiService;

class PlanetController
{
    public function listPlanets() {
        try {
            $swapiService = new SwapiService();
            $planets = $swapiService->fetchAllPlanets();
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $planets
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
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
            echo json_encode([
                'success' => true,
                'data' => $planets
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch planets'
            ], 500);
        }
    }
}