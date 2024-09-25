<?php

namespace App\Tests\Service;

use App\Service\OmdbClient;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OmdbClientTest extends TestCase
{
  /** @var HttpClientInterface&\PHPUnit\Framework\MockObject\MockObject */
  private $httpClient;
  private $omdbClient;

  protected function setUp(): void
  {
    $this->httpClient = $this->createMock(HttpClientInterface::class);
    $this->omdbClient = new OmdbClient($this->httpClient, 'fake_api_key');
  }

  public function testSearchMovies()
  {
    $response = $this->createMock(ResponseInterface::class);
    $response->method('toArray')->willReturn([
      'Search' => [
        ['Title' => 'Movie 1', 'Year' => '2021', 'imdbID' => 'tt1234567', 'Type' => 'movie', 'Poster' => 'N/A'],
        ['Title' => 'Movie 2', 'Year' => '2020', 'imdbID' => 'tt7654321', 'Type' => 'movie', 'Poster' => 'N/A'],
      ]
    ]);

    $this->httpClient->method('request')->willReturn($response);

    $movies = $this->omdbClient->searchMovies('test');

    $this->assertCount(2, $movies);
    $this->assertEquals('Movie 1', $movies[0]['Title']);
    $this->assertEquals('Movie 2', $movies[1]['Title']);
  }

  public function testGetMovieByImdbID()
  {
    $response = $this->createMock(ResponseInterface::class);
    $response->method('toArray')->willReturn([
      'Title' => 'Movie 1',
      'Year' => '2021',
      'imdbID' => 'tt1234567',
      'Type' => 'movie',
      'Poster' => 'N/A',
      'Plot' => 'Some plot'
    ]);

    $this->httpClient->method('request')->willReturn($response);

    $movie = $this->omdbClient->getMovieByImdbID('tt1234567');

    $this->assertNotNull($movie);
    $this->assertEquals('Movie 1', $movie['Title']);
    $this->assertEquals('2021', $movie['Year']);
  }
}
