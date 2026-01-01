<?php

use App\Core\Router;
use App\Controller\FilmController;
use App\Controller\CharacterController;

$router = new Router();

$router->get('/api/films', [FilmController::class, 'listFilms']);
$router->get('/api/films/{id}', [FilmController::class, 'getFilmsById']);

$router->get('/api/characters/{id}', [CharacterController::class, 'getCharacter']);
$router->get('/api/planets/{id}', [PlanetController::class, 'getPlanet']);
$router->get('/api/starships/{id}', [StarshipController::class, 'getStarship']);
$router->get('/api/vehicles/{id}', [VehicleController::class, 'getVehicle']);
$router->get('/api/species/{id}', [SpeciesController::class, 'getSpecies']);
return $router;