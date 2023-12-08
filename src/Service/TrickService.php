<?php

namespace App\Service;

use App\Entity\Trick;
use App\Model\TrickDetails;
use App\Mapper\TricksMapper;
use Doctrine\ORM\EntityManagerInterface;

class TrickService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TricksMapper $tricksMapper,
        ) { }

    public function getPaginatedHomeTricks(int $limit, int $page): array
    {
        
        $tricks = $this->entityManager->getRepository(Trick::class)->findAll();
        return $this->tricksMapper->transformToTricksDetails($tricks);
    }

    public function getTrickDetails(string $slug): TrickDetails
    {
        $trick = $this->entityManager->getRepository(Trick::class)->findOneBySlug($slug);
        return $this->tricksMapper->getTrickDetails($trick);
    }

}
