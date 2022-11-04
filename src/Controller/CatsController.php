<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatsController extends AbstractController
{
    #[Route('/cats', name: 'cats_types')]
    public function index(): Response
    {
        $cat_types = ['black cat', 'white cat', 'mix coloured fur cat'];
        return $this->render("index.html.twig",
            array("cat_types" => $cat_types));
    }
}
