<?php

use App\Core\Router;
use App\Controller\FilmController;
use App\Controller\CharacterController;
use App\Controller\PlanetController;
use App\Controller\StarshipController;
use App\Controller\VehicleController;
use App\Controller\SpeciesController;

$router = new Router();

$router->get('/api/films', [FilmController::class, 'listFilms']);
$router->get('/api/films/{id}', [FilmController::class, 'getFilmsById']);

$router->get('/api/characters', [CharacterController::class, 'listCharacters']);
$router->get('/api/characters/{id}', [CharacterController::class, 'getCharacter']);

$router->get('/api/planets', [PlanetController::class, 'listPlanets']);
$router->get('/api/planets/{id}', [PlanetController::class, 'getPlanet']);

$router->get('/api/starships', [StarshipController::class, 'listStarships']);
$router->get('/api/starships/{id}', [StarshipController::class, 'getStarship']);

$router->get('/api/vehicles', [VehicleController::class, 'listVehicles']);
$router->get('/api/vehicles/{id}', [VehicleController::class, 'getVehicle']);

$router->get('/api/species', [SpeciesController::class, 'listSpecies']);
$router->get('/api/species/{id}', [SpeciesController::class, 'getSpecies']);
return $router;