<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatsController extends AbstractController
{

    public function __construct(CatRepository $catRepository)
    {
        $this->catRepository = $catRepository;
    }

    #[Route('/cats', name: 'cats')]
    public function index(): Response
    {
        $cats = $this->catRepository->findAll();
        return $this->render('cats/index.html.twig', [
            'cats' => $cats
        ]);
    }

    #[Route('/cats/{id}', name: 'cat', methods: ['GET'])]
    public function show($id): Response
    {
        $cat = array("name" => "Kot", "imagePath" => "https://pixabay.com/photos/cat-young-animal-kitten-gray-cat-2083492/", "description" => "sus", "id" => "1");
        return $this->render('cats/show.html.twig', [
            'cat' => $cat
        ]);
    }
}
