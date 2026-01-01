<?php

namespace App\Service;

use Exception;

class SwapiService
{
    private string $baseUrl;

    private array $routes = [
        'films' => 'films/',
    ];

    public function __construct()
    {
        if (empty($_ENV['API_SWAPI'])) {
            throw new Exception("Environment variable API_SWAPI is not set.");
        }
        $this->baseUrl = $_ENV['API_SWAPI'];
    }

    public function fetchAllFilms(): array
    {
        $endpoint = $this->baseUrl . $this->routes['films'];
        $data = $this->request($endpoint);
        $today = new \DateTime();
        foreach($data['results'] as &$film) {
            $film['id'] = basename($film["url"]);
            $releaseDate = new \DateTime($film['release_date']);
            $interval = $releaseDate->diff($today);
            $film['interval'] = [
                'years' => $interval->y,
                'months' => $interval->m,
                'days' => $interval->d,
            ];
        }
        unset($film);
        return $data;
    }

    public function fetchFilmById(int $id): array
    {
        $endpoint = $this->baseUrl . $this->routes['films'] . $id . '/';
        $filmData = $this->request($endpoint);

        $releaseDate = new \DateTime($filmData['release_date']);
        $now = new \DateTime();
        $diff = $releaseDate->diff($now);

        $filmData['interval'] = [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];

        $filmData['character_names'] = $this->getCharacterNames($filmData['characters']);

        unset($filmData['characters']);

        return $filmData;
    }

    private function getCharacterNames(array $urls): array
    {
        $names = [];

        foreach ($urls as $url) {
            try {
                $personData = $this->request($url);
                $names[] = $personData['name'];
            } catch (Exception $e) {
                $names[] = 'Unknown Character';
            }
        }

        return $names;
    }

    private function request(string $url): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("Connection Error: " . $curlError);
        }

        if ($httpCode >= 400) {
            throw new Exception("API Error (Status $httpCode)");
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Parse Error: " . json_last_error_msg());
        }

        return $data;
    }
}