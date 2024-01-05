<?php

/**
 * HomeController File Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Controller;

use App\Service\TrickService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * HomeController Class Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class HomeController extends AbstractController
{
    /**
     * Summary of function __construct
     *
     * @param TrickService $trickService TrickService
     */
    public function __construct(private readonly TrickService $trickService)
    { }

    /**
     * Summary of function home
     *
     * Get the tricks paginated to display on the homepage
     *
     * @param Request $request Request
     *
     * @return Response
     */
    #[Route('/', name: 'home', methods: ['GET', 'HEAD'])]
    public function home(Request $request): Response
    {
        $page = $request->query->getInt("page", 1);

        $dataPaginated = $this->trickService->getPaginatedHomeTricks($page, 12);

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $dataPaginated['tricks'],
            'pages' => $dataPaginated['pages'],
            'page' => $dataPaginated['page'],
            'limit' => $dataPaginated['limit'],
        ]);
    }
}
