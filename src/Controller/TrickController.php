<?php

/**
 * TrickController File Doc Comment
 *
 * PHP Version 8.3.1
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Controller;

use App\Service\TrickService;
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
     * @param TrickService $trickService TrickService
     */
    public function __construct(private readonly TrickService $trickService)
    { }

    /**
     * Summary of function show
     *
     * Get tricks details to display it
     *
     * @param string $slug Slug
     *
     * @return Response
     */
    #[Route('/trick/{slug}', name: 'trickDetail', methods: ['GET', 'HEAD'])]
    public function show(string $slug): Response
    {
        $trick = $this->trickService->getTrickDetails($slug);

        return $this->render('trick/trick.html.twig', [
            'trick' => $trick
        ]);
    }
}
