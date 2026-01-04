<?php
use App\Core\Router;
use App\Controller\FilmController;
use App\Controller\CharacterController;
use App\Controller\PlanetController;
use App\Controller\SpeciesController;
use App\Controller\StarshipController;
use App\Controller\VehicleController;

$router->get('/', [FilmController::class, 'index']);
$router->get('/films', [FilmController::class, 'index']);
$router->get('/films/{id}', [FilmController::class, 'show']);

$router->get('/characters', [CharacterController::class, 'index']);
$router->get('/characters/{id}', [CharacterController::class, 'show']);

$router->get('/planets', [PlanetController::class, 'index']);
$router->get('/planets/{id}', [PlanetController::class, 'show']);

$router->get('/species', [SpeciesController::class, 'index']);
$router->get('/species/{id}', [SpeciesController::class, 'show']);

$router->get('/starships', [StarshipController::class, 'index']);
$router->get('/starships/{id}', [StarshipController::class, 'show']);

$router->get('/vehicles', [VehicleController::class, 'index']);
$router->get('/vehicles/{id}', [VehicleController::class, 'show']);

