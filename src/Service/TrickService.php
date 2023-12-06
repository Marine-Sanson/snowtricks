<?php

namespace App\Service;

use App\Entity\Trick;
use App\Mapper\TricksMapper;
use Doctrine\ORM\EntityManagerInterface;

class TrickService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TricksMapper $tricksMapper
        ) { }

    public function getHomeTricks(): array
    {
        $tricks = $this->entityManager->getRepository(Trick::class)->findAll();
        return $this->tricksMapper->transformToHomeTricks($tricks);
    }

}
