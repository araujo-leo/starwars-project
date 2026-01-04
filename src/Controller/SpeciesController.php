<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;
use App\Service\SwapiService;

class SpeciesController extends BaseController
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
            $this->jsonResponse([
                'success' => true,
                'data' => $species,
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
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
            $this->jsonResponse([
                'success' => true,
                'data' => $species,
            ], 200 );
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'error' => true,
                'message' => 'Failed to fetch specie'
            ], 500);
        }
    }
}