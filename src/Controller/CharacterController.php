<?php

namespace App\Controller;
use App\Service\SwapiService;

class CharacterController
{
    public function getCharacter($id)
    {
        try {
            $swapiService = new SwapiService();
            $films = $swapiService->fetchCharacterById($id);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $films
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch films'
            ], 500);
        }
    }
}