<?php

namespace App\Service;

use DateTime;
use Exception;

class SwapiService extends BaseApiService
{
    private string $baseUrl;
    private array $tradeFields = [
        'residents',
        'films',
        'characters',
        'planets',
        'starships',
        'vehicles',
        'species'
    ];

    private array $routes = [
        'films' => 'films/',
        'characters' => 'people/',
        'planets' => 'planets/',
        'species' => 'species/',
        'starships' => 'starships/',
        'vehicles' => 'vehicles/',
    ];

    public function __construct()
    {
        $this->baseUrl = $_ENV['API_SWAPI'] ?? 'https://swapi.dev/api/';
    }

    public function fetchAllFilms(): array
    {
        $url = $this->baseUrl . $this->routes['films'];
        $data = $this->request($url);

        foreach ($data['results'] as &$film) {
            $film['id'] = $this->extractIdFromUrl($film['url']);
        }

        return $data;
    }

    public function fetchFilmById(int $id): array
    {
        $url = $this->baseUrl . $this->routes['films'] . $id . '/';
        $filmData = $this->request($url);

        $releaseDate = new DateTime($filmData['release_date']);
        $diff = $releaseDate->diff(new DateTime());
        $filmData['interval'] = [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];

        $filmData['id'] = $this->extractIdFromUrl($filmData['url']);

        foreach ($this->tradeFields as $field) {
            if (isset($filmData[$field]) && is_array($filmData[$field])) {
                $filmData[$field] = $this->enrichListWithLocalUrls($filmData[$field]);
            }
        }

        return $filmData;
    }

    public function fetchCharacterById(int $id): array
    {
        return $this->fetchById('characters',$id);
    }

    public function fetchPlanetById(int $id): array
    {
        return $this->fetchById('planets',$id);
    }

    public function fetchSpecieById(int $id): array
    {
        return $this->fetchById('species',$id);
    }

    public function fetchStarshipById(int $id): array
    {
        return $this->fetchById('starships',$id);
    }

    public function fetchVehicleById(int $id): array
    {
        return $this->fetchById('vehicles',$id);
    }

    private function fetchById(string $route, int $id): array   {
        $url = $this->baseUrl . $this->routes[$route] . $id . '/';
        $data = $this->request($url);
        $data['id'] = $this->extractIdFromUrl($data['url']);

        foreach($this->tradeFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = $this->enrichListWithLocalUrls($data[$field]);
            }
        }

        return $data;
    }


}