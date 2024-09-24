<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class MovieController extends AbstractController
{
    #[Route('/film/add', name: 'add_movie')]
    public function add(Request $request, EntityManagerInterface $entityManager, MovieRepository $movieRepository): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existingMovie = $movieRepository->findOneBy([
                'title' => $movie->getTitle(),
                'year' => $movie->getYear()
            ]);

            if (!$existingMovie) {
                $entityManager->persist($movie);
                $entityManager->flush();

                flash()->success(sprintf('Movie "%s" added successfully!', $movie->getTitle()));

                return $this->redirectToRoute('homepage');
            } else {
                flash()->error('A movie with this title already exists.');

                return $this->redirectToRoute('add_movie');
            }
        }

        return $this->render('movie/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/film/{id}', name: 'movie_detail')]
    public function detail(Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/film/edit/{id}', name: 'edit_movie')]
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            flash()->success(sprintf('Movie "%s" updated successfully!', $movie->getTitle()));

            return $this->redirectToRoute('movie_detail', ['id' => $movie->getId()]);
        }

        return $this->render('movie/edit.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie,
        ]);
    }

    #[Route('/film/delete/{id}', name: 'delete_movie', methods: ['POST'])]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $movie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();

            flash()->success(sprintf('Movie "%s" deleted successfully!', $movie->getTitle()));
        }

        return $this->redirectToRoute('homepage');
    }
}