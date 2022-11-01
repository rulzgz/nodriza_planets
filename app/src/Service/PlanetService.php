<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlanetService
{
    public function __construct(private string $baseUrl, private HttpClientInterface $client)
    {
    }

    /**
     * @param integer $id Planet's id
     * @return array
     */
    public function get(int $id): array
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . 'planets/' . $id . '/'
        );

        // Pasamos false a $response->toArray() para evitar que curl lance una excepción
        return [
            'status' => $response->getStatusCode(),
            'content' => $response->toArray(false),
        ];
    }
}