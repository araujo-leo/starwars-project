<?php

namespace App\Controller;
use App\Core\View;
use App\Service\SwapiService;

class CharacterController
{
    public function index(){
        return View::render("characters");
    }
    public function listCharacters() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $characters = $swapiService->fetchAllCharacters($page);
            header('Content-Type: application/json');
            echo json_encode([
                'succes' => true,
                'data' => $characters
            ], 200);
        } catch (Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch characters'
            ], 500);
        }
    }
    public function getCharacter($id)
    {
        try {
            $swapiService = new SwapiService();
            $characters = $swapiService->fetchCharacterById($id);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $characters
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch characters'
            ], 500);
        }
    }
}