<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbClient
{
  private $httpClient;
  private $apiKey;

  public function __construct(HttpClientInterface $httpClient, string $apiKey)
  {
    $this->httpClient = $httpClient;
    $this->apiKey = $apiKey;
  }

  public function searchMovies(string $query): array
  {
    $response = $this->httpClient->request('GET', 'https://www.omdbapi.com/', [
      'query' => [
        'apikey' => $this->apiKey,
        's' => $query,
      ],
    ]);

    $data = $response->toArray();
    return $data['Search'] ?? [];
  }
}