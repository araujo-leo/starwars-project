<?php

namespace App\Service;

use DateTime;
use Exception;

class SwapiService extends BaseApiService
{
    private string $baseUrl;

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

        $relatedFields = ['characters', 'planets', 'starships', 'vehicles', 'species'];

        foreach ($relatedFields as $field) {
            if (isset($filmData[$field]) && is_array($filmData[$field])) {
                $filmData[$field] = $this->enrichListWithLocalUrls($filmData[$field]);
            }
        }

        return $filmData;
    }

    public function fetchCharacterById(int $id): array
    {
        $url = $this->baseUrl . $this->routes['characters'] . $id . '/';
        $characterData = $this->request($url);


        $relatedFields = ['characters', 'planets', 'starships', 'vehicles', 'species'];

        foreach ($relatedFields as $field) {
            if (isset($characterData[$field]) && is_array($characterData[$field])) {
                $characterData[$field] = $this->enrichListWithLocalUrls($characterData[$field]);
            }
        }

        return $characterData;
    }


}