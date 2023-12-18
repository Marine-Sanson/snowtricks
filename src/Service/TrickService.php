<?php

namespace App\Service;

use App\Entity\Trick;
use App\Model\TrickDetails;
use App\Mapper\TricksMapper;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrickService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository $trickRepository,
        private readonly TricksMapper $tricksMapper,
        ) { }

    public function getPaginatedHomeTricks(int $page, int $limit): array
    {
        $data = $this->trickRepository->findTricksPaginated($page, $limit);
        $data['tricks'] = $this->tricksMapper->transformToHomeTricks($data['tricks']);

        return $data;
    }

    public function getTrickDetails(string $slug): TrickDetails
    {
        $trick = $this->trickRepository->findOneBySlug($slug);
        return $this->tricksMapper->getTrickDetails($trick);
    }

}
