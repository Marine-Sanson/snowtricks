<?php

/**
 * TrickController File Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Controller;

use App\Model\CommentModel;
use App\Service\UserService;
use App\Form\CommentFormType;
use App\Service\TrickService;
use App\Service\CommentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * TrickController Class Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TrickController extends AbstractController
{
    /**
     * Summary of function __construct
     *
     * @param TrickService   $trickService   TrickService
     * @param CommentService $commentService CommentService
     * @param UserService    $userService    UserService
     */
    public function __construct(
        private readonly TrickService $trickService,
        private readonly CommentService $commentService,
        private readonly UserService $userService,
    ) { }

    /**
     * Summary of function show
     *
     * Get tricks details to display it
     *
     * @param string $slug Slug
     *
     * @return Response
     */
    #[Route('/trick/{slug}', name: 'trickDetail', methods: ['GET', 'POST', 'HEAD'])]
    public function show(string $slug, Request $request): Response
    {
        $page = $request->query->getInt("page", 1);
        $trick = $this->trickService->getTrickDetails($slug);

        $dataPaginated = $this->commentService->getPaginatedTrickComments($trick, $page, 10);

        if ($dataPaginated === []){
            $dataPaginated = [
                'comments' => [],
                'pages' => null,
                'page' => null,
                'limit' => null,
            ];
        }

        $userConnected = $this->getUser();

        if ($userConnected) {
            $comment = new CommentModel();

            $commentForm = $this->createForm(CommentFormType::class, $comment);
            $commentForm->handleRequest($request);
    
            if($commentForm->isSubmitted() && $commentForm->isValid()){
                $this->commentService->addComment(
                    $commentForm->get("content")->getData(), 
                    $commentForm->get("trickId")->getData(), 
                    $commentForm->get("userId")->getData(), 
                );
            }

            return $this->render('trick/trick.html.twig', [
                'trick' => $trick,
                'mainName' => $trick->getMainMedia()->getName(),
                'commentForm' => $commentForm,
                'comments' => $dataPaginated['comments'],
                'pages' => $dataPaginated['pages'],
                'page' => $dataPaginated['page'],
                'limit' => $dataPaginated['limit'],
            ]);
        }//end if

        return $this->render('trick/trick.html.twig', [
            'trick' => $trick,
            'mainName' => $trick->getMainMedia()->getName(),
            'comments' => $dataPaginated['comments'],
            'pages' => $dataPaginated['pages'],
            'page' => $dataPaginated['page'],
            'limit' => $dataPaginated['limit'],
        ]);
    }
}
