<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class SpeciesController
{
    public function index() :string
    {
        try {
            return View::render("species/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }

    }

    public function show(int $id) :string
    {
        try{
            return View::render("species/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }
    public function listSpecies() :void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $species = $swapiService->fetchAllSpecies($page);
            header('Content-Type: application/json');

            Log::save('INFO', "/species?page=$page");
            echo json_encode([
                'succes' => true,
                'data' => $species
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/species?page=$page");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
    public function getSpecies(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $species = $swapiService->fetchSpecieById($id);
            header('Content-Type: application/json');

            Log::save('INFO', "/species?id=$id");
            echo json_encode([
                'success' => true,
                'data' => $species
            ], 200);
        } catch (\Exception $e) {
            http_response_code(500);
            error_log($e->getMessage());

            Log::save('ERROR', "/species?id=$id");
            echo json_encode([
                'error' => true,
                'message' => 'Failed to fetch species'
            ], 500);
        }
    }
}