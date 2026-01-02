<?php
use App\Core\Router;
use App\Controller\FilmController;
use App\Controller\CharacterController;
$router->get('/', [FilmController::class, 'index']);
$router->get('/films', [FilmController::class, 'index']);
$router->get('/filme/{id}', [FilmController::class, 'show']);


$router->get('/characters', [CharacterController::class, 'index']);
