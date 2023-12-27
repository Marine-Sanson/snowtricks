<?php

namespace App\Controller;

use App\Entity\Trick;
use DateTimeImmutable;
use App\Form\TricksFormType;
use App\Service\TrickService;
use App\Entity\CreatedAtTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/tricks', name: 'app_admin_tricks_')]
class AdminTricksController extends AbstractController
{
    use CreatedAtTrait;

    public function __construct(
        private readonly TrickService $trickService,
        private readonly SluggerInterface $slugger
    ) {}


    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin_tricks/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $trick = new Trick();
        $trickForm = $this->createForm(TricksFormType::class, $trick);

        $trickForm->handleRequest($request);

        if($trickForm->isSubmitted() && $trickForm->isValid()){
            $isTrickNameKnown = $this->trickService->isTrickNameKnown($trick->getName());

            if($isTrickNameKnown === true){
                $this->addFlash('danger', 'Un Trick porte déjà ce nom');
                return $this->render('trick/add.html.twig', [
                    'trickForm' => $trickForm->createView(),
                ]);
            }

            $trick->setSlug($this->slugger->slug($trick->getName()));
            $trick->setUpdatedAt($trick->getCreatedAt());

            $this->trickService->saveTrick($trick);
    
            $this->addFlash('success', 'Trick ajouté avec succes');
            return $this->redirectToRoute('home');
        }

        return $this->render('trick/add.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }

    #[Route('/maj/{id}', name: 'edit')]
    public function edit(Trick $trick, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $trickForm = $this->createForm(TricksFormType::class, $trick);

        $trickForm->handleRequest($request);

        if($trickForm->isSubmitted() && $trickForm->isValid()){

            $trick->setCreatedAt(new DateTimeImmutable());

            $this->trickService->saveTrick($trick);
    
            $this->addFlash('success', 'Trick modifié avec succes');
            return $this->redirectToRoute('home');
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Trick $trick): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin_tricks/index.html.twig');
    }
}
