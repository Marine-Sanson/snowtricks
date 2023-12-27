<?php

namespace App\Controller;

use App\Service\TrickService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    public function __construct(private readonly TrickService $trickService)
    { }

    #[Route('/trick/{slug}', name: 'trickDetail', methods: ['GET', 'HEAD'])]
    public function show(string $slug): Response
    {
        $trick = $this->trickService->getTrickDetails($slug);

        return $this->render('trick/trick.html.twig', [
            'trick' => $trick
        ]);
    }
}
