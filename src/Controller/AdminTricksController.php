<?php

/**
 * AdminTricksController File Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use DateTimeImmutable;
use App\Form\TricksFormType;
use App\Service\MediaService;
use App\Service\TrickService;
use App\Entity\CreatedAtTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * AdminTricksController Class Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[Route('/admin/tricks', name: 'app_admin_tricks_')]
class AdminTricksController extends AbstractController
{
    use CreatedAtTrait;

    /**
     * Summary of function __construct
     *
     * @param TrickService     $trickService TrickService
     * @param SluggerInterface $slugger      SluggerInterface
     * @param MediaService     $mediaService MediaService
     */
    public function __construct(
        private readonly TrickService $trickService,
        private readonly SluggerInterface $slugger,
        private readonly MediaService $mediaService,
    ) {}

    /**
     * Summary of function index
     *
     * @return Response
     */
    #[Route('/', name: 'index', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {

        return $this->render('admin_tricks/index.html.twig');

    }

    /**
     * Summary of function add
     *
     * Create a new trick and his his medias
     *
     * @param Request $request Request
     *
     * @return Response
     */
    #[Route('/ajout', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $trick = new Trick();
        $trickForm = $this->createForm(TricksFormType::class, $trick);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $images = $trickForm->get('images')->getData();

            $isTrickNameKnown = $this->trickService->isTrickNameKnown($trick->getName());

            if ($isTrickNameKnown === true) {
                $this->addFlash('danger', 'Un Trick porte déjà ce nom');
                return $this->render('trick/add.html.twig', [
                    'trickForm' => $trickForm->createView(),
                ]);
            }

            foreach ($images as $image) {
                $mediaImg = $this->mediaService->addNewImage($image, 'tricks', 1);
                $trick->addMedium($mediaImg);
            }

            $videos = $trickForm->get('videos')->getData();

            if (preg_match_all('/(https?:\/\/www\.youtube\.com\/watch\?v=)([a-zA-Z0-9-_\.\/\?=&]+)/', $videos, $matches)) {
                foreach ($matches[2] as $video) {
                    $mediaVid = $this->mediaService->addNewVideo($video);
                    $trick->addMedium($mediaVid);
                }
            }

            $trick->setSlug($this->slugger->slug($trick->getName()));
            $trick->setUpdatedAt($trick->getCreatedAt());

            $this->trickService->saveTrick($trick);

            $this->addFlash('success', 'Trick ajouté avec succes');
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'trick/add.html.twig', [
                'trickForm' => $trickForm->createView(),
            ]
        );

    }

    /**
     * Summary of function edit
     *
     * Update a trick and his his medias
     *
     * @param Trick   $trick   Trick
     * @param Request $request Request
     *
     * @return Response
     */
    #[Route('/maj/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Trick $trick, Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $trickForm = $this->createForm(TricksFormType::class, $trick);

        $trickForm->handleRequest($request);

        if($trickForm->isSubmitted() && $trickForm->isValid()){
            $trick->setUpdatedAt(new DateTimeImmutable());

            $images = $trickForm->get('images')->getData();

            foreach ($images as $image){
                $mediaImg = $this->mediaService->addNewImage($image, 'tricks', 1);
                $trick->addMedium($mediaImg);
            }

            $videos = $trickForm->get('videos')->getData();
            if (preg_match_all('/(https?:\/\/www\.youtube\.com\/watch\?v=)([a-zA-Z0-9-_\.\/\?=&]+)/', $videos, $matches)) {

                foreach( $matches[2] as $video) {
                    $mediaVid = $this->mediaService->addNewVideo($video);
                    $trick->addMedium($mediaVid);
                }
            }

            $this->trickService->saveTrick($trick);

            $this->addFlash('success', 'Trick modifié avec succes');
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'trick/edit.html.twig', [
                'trickForm' => $trickForm->createView(),
                'trick' => $trick
            ]
        );

    }

    /**
     * Summary of function deleteImage
     *
     * Delete an image in the uploads file and in the DB
     *
     * @param Media $media Media
     *
     * @return Response
     */
    #[Route('/suppression/media/{id}', name: 'delete_media', methods: ['GET'])]
    public function deleteMedia(Media $media): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $deleted = $this->mediaService->deleteMedia($media);

        if ($deleted) {
            $this->addFlash('success', 'Media supprimé avec succes');
            return $this->render('admin_tricks/index.html.twig');
        }

        $this->addFlash('danger', 'Un problème est survenu');
        return $this->render('admin_tricks/index.html.twig');

    }

    /**
     * Summary of function delete
     *
     * Delete a trick and his medias
     *
     * @param Trick $trick Trick
     *
     * @return Response
     */
    #[Route('/suppression/{id}', name: 'delete_trick', methods: ['GET'])]
    public function delete(Trick $trick): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deleted = $this->trickService->deleteTrick($trick);
        if ($deleted) {
            $this->addFlash('success', 'Trick supprimé avec succes');
            return $this->redirectToRoute('home');
        }

        $this->addFlash('danger', 'Un problème est survenu');
        return $this->render('admin_tricks/index.html.twig');

    }

}
