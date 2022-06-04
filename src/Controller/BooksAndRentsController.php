<?php

namespace App\Controller;

use App\Repository\BooksAndRentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BooksAndRentsController extends AbstractController
{
    #[Route('/', name: 'app_books_and_rents')]
    public function index(): Response
    {
        return $this->render('books_and_rents/index.html.twig', [
            'controller_name' => 'BooksAndRentsController',
        ]);
    }


    #[Route('/books/all', name: 'app_books_and_rents_all', methods: ['GET', 'POST'])]
    public function getAll(BooksAndRentsRepository $repo): Response
    {
        return $this->json(['BooksAll'=>$repo->findAll(),Response::HTTP_ACCEPTED]);
    }

    #[Route('/books/ISBN/{ISBN}', name: 'app_books_and_rents_ISBN', methods: ['GET', 'POST'])]
    public function findByISBN($ISBN, BooksAndRentsRepository $repo): Response
    {
        return $this->json(['BooksAll'=>$repo->findByISBN($ISBN),Response::HTTP_ACCEPTED]);
    }
}
