<?php

namespace App\Controller;

use App\Service\OmdbClient;
use App\Entity\Movie;
use App\Class\MovieDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;

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

  #[Route('/omdb/add/{imdbID}', name: 'add_to_library', methods: ['POST'])]
  public function addToLibrary(string $imdbID, OmdbClient $omdbClient, EntityManagerInterface $entityManager, MovieRepository $movieRepository, Request $request): Response
  {
    $result = $omdbClient->getMovieByImdbID($imdbID);

    $existingMovie = $movieRepository->findOneBy([
      'title' => $result['Title'],
      'year' => (int)$result['Year']
    ]);

    if (!$existingMovie) {
      $movie = new Movie();
      $movie->setTitle($result['Title']);
      $movie->setYear((int)$result['Year']);
      $movie->setType($result['Type']);
      $movie->setAbstract($result['Plot']);
      $movie->setPoster($result['Poster']);
      $movie->setStatus('unseen');

      $entityManager->persist($movie);
      $entityManager->flush();

      flash()->success(sprintf('Movie "%s - %s" added to your library!', $movie->getTitle(), $movie->getYear()));
      return $this->redirectToRoute('homepage');
    } else {
      flash()->error('Movie already in your library!');
      return $this->redirect($request->headers->get('referer'));
    }
  }
}