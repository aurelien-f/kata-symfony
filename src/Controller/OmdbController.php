<?php

namespace App\Controller;

use App\Service\OmdbClient;
use App\Class\MovieDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OmdbController extends AbstractController
{
  #[Route('/omdb', name: 'omdb_search')]
  public function searchOmdb(Request $request, OmdbClient $omdbClient): Response
  {

    $query = $request->query->get('q', '');
    $movies = [];

    if ($query) {
      $results = $omdbClient->searchMovies($query);
      foreach ($results as $result) {
        $movies[] = new MovieDTO($result);
      }
    }

    return $this->render('omdb/search.html.twig', [
      'movies' => $movies,
      'query' => $query,
    ]);
  }
}