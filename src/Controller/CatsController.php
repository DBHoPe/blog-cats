<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatFormType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatsController extends AbstractController
{
    public function __construct(CatRepository $catRepository, EntityManagerInterface $entityManager)
    {
        $this->catRepository = $catRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('cats');
    }

    #[Route('/cats', name: 'cats')]
    public function index(): Response
    {
        $cats = $this->catRepository->findAll();
        return $this->render('cats/index.html.twig', [
            'cats' => $cats
        ]);
    }

    #[Route('/cats/create', name: 'create_cats')]
    public function create(Request $request): Response
    {
        $cat = new Cat();
        $form = $this->createForm(CatFormType::class, $cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newCat = $form->getData();

            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->getExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . 'public/uploads',
                        $newFileName
                    );
                } catch (FileException $error) {
                    return new Response($error->getMessage());
                }

                $newCat->setImagePath('public/uploads/' . $newFileName);
            }

            $this->entityManager->persist($newCat);
            $this->entityManager->flush();

            return $this->redirectToRoute('cats');
        }
        return $this->render('cats/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/cats/edit/{id}', name: 'edit_cats')]
    public function edit($id, Request $request): Response
    {
        $cat = $this->catRepository->find($id);
        $form = $this->createForm(CatFormType::class, $cat);
        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($cat->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $cat->getImagePath()
                    )) {
                        $this->getParameter('kernel.project_dir') . $cat->getImagePath();

                        $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                        try {
                            $imagePath->move(
                                $this->getParameter('kernel.project_dir') . 'public/uploads',
                                $newFileName
                            );
                        } catch (FileException $error) {
                            return new Response($error->getMessage());
                        }

                        $cat->setDescription('/uploads' . $newFileName);
                        $this->entityManager->flush();

                        return $this->redirectToRoute('cats');
                    }
                }
            } else {
                $cat->setName($form->get('name')->getData());
                $cat->setDescription($form->get('description')->getData());

                $this->entityManager->flush();
                $this->redirectToRoute('cats');
            }
        }

        return $this->render('cats/edit.html.twig', [
            'cat' => $cat,
            'form' => $form->createView()
        ]);
    }

    #[Route('/cats/delete/{id}', name: 'delete_cats', methods: ['GET', 'DELETE'])]
    public function delete($id, Request $request): Response
    {
        $cat = $this->catRepository->find($id);
        $this->entityManager->remove($cat);
        $this->entityManager->flush();

        return $this->redirectToRoute('cats');
    }

    #[Route('/cats/{id}', name: 'cat', methods: ['GET'])]
    public function show($id): Response
    {
        $cat = $this->catRepository->find($id);
        return $this->render('cats/show.html.twig', [
            'cat' => $cat
        ]);
    }
}
