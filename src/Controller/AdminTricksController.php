<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/tricks', name: 'app_admin_tricks_')]
class AdminTricksController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin_tricks/index.html.twig', [
            'controller_name' => 'AdminTricksController',
        ]);
    }

    #[Route('/ajout', name: 'add')]
    public function add(): Response
    {
        return $this->render('admin_tricks/index.html.twig');
    }

    #[Route('/maj/{id}', name: 'edit')]
    public function edit(Trick $trick): Response
    {
        return $this->render('admin_tricks/index.html.twig');
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Trick $trick): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin_tricks/index.html.twig');
    }
}
