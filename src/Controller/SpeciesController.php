<?php

namespace App\Controller;

use App\Service\SwapiService;

class SpeciesController
{
    public function listSpecies() {
        try {
            $swapiService = new SwapiService();
            $species = $swapiService->fetchAllSpecies();
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $species
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
    public function getSpecies($id)
    {
        try {
            $swapiService = new SwapiService();
            $species = $swapiService->fetchSpecieById($id);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $species
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
}