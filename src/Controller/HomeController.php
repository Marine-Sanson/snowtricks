<?php

namespace App\Controller;

use App\Service\TrickService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private readonly TrickService $trickService)
    { }

    #[Route('/', name: 'home', methods: ['GET', 'HEAD'])]
    public function home(Request $request): Response
    {
        $page = $request->query->getInt("page", 1);

        $dataPaginated = $this->trickService->getPaginatedHomeTricks($page, 4);



        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $dataPaginated['tricks'],
            'pages' => $dataPaginated['pages'],
            'page' => $dataPaginated['page'],
            'limit' => $dataPaginated['limit'],
        ]);
    }
}
