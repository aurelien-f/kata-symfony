<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/film/add', name: 'add_movie')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            $this->addFlash('success', 'Movie added successfully!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('movie/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}