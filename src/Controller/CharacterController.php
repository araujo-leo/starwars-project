<?php

namespace App\Controller;
use App\Core\View;
use App\Service\SwapiService;
use App\Model\Log;

class CharacterController
{
    public function index(){
        try {
            return View::render("characters/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }

    }

    public function show($id){
        try{
            return View::render("characters/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }
    public function listCharacters() {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $characters = $swapiService->fetchAllCharacters($page);
            header('Content-Type: application/json');

            Log::save('INFO', "/characters?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $characters
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            Log::save('ERROR', "/characters" );
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

            Log::save('INFO', "/characters/$id");
            echo json_encode([
                'success' => true,
                'data' => $characters
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());
            Log::save('ERROR', "/characters/$id" );
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch characters'
            ], 500);
        }
    }
}