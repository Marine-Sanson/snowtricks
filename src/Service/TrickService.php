<?php

namespace App\Service;

use App\Entity\Trick;
use App\Mapper\MediaMapper;
use App\Model\TrickDetails;
use App\Mapper\TricksMapper;
use App\Repository\MediaRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrickService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository $trickRepository,
        private readonly MediaRepository $mediaRepository,
        private readonly TricksMapper $tricksMapper,
        private readonly MediaMapper $mediaMapper
        ) { }

    public function getPaginatedHomeTricks(int $page, int $limit): array
    {
        $data = $this->trickRepository->findTricksPaginated($page, $limit);
        $data['tricks'] = $this->tricksMapper->transformToHomeTricks($data['tricks']);

        $defaultMedia = $this->mediaMapper->getMediaModel($this->mediaRepository->find(11));

        foreach ($data['tricks'] as $trick) {
            if ($trick->getMedia() === null) {
                $trick->setMedia($defaultMedia);
            }
        }

        return $data;
    }

    public function getTrickDetails(string $slug): TrickDetails
    {
        $trick = $this->trickRepository->findOneBySlug($slug);
        
        return $this->tricksMapper->getTrickDetails($trick);
    }

    public function isTrickNameKnown(string $trickName): bool
    {
        $knownTrick = $this->trickRepository->findOneByName($trickName);
        if($knownTrick){
            return true;
        }
        return false;
    }

    public function saveTrick(Trick $trick): void
    {
        $this->trickRepository->saveTrick($trick);
    }

    public function deleteTrick(Trick $trick): bool
    {
        if($this->trickRepository->findOneById($trick->getId()) === null){
            return false;
        }
        $this->trickRepository->delete($trick);
        return true;
    }

}
