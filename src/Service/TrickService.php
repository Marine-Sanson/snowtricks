<?php

/**
 * TrickService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use App\Entity\Trick;
use App\Mapper\MediaMapper;
use App\Model\TrickDetails;
use App\Mapper\TricksMapper;
use App\Repository\MediaRepository;
use App\Repository\TrickRepository;
use App\Repository\TrickMediaRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * TrickService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TrickService
{
    /**
     * Summary of function __construct
     *
     * @param EntityManagerInterface $entityManager   EntityManagerInterface
     * @param TrickRepository        $trickRepository TrickRepository
     * @param MediaRepository        $mediaRepository MediaRepository
     * @param TricksMapper           $tricksMapper    TricksMapper
     * @param MediaMapper            $mediaMapper     MediaMapper
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository $trickRepository,
        private readonly MediaRepository $mediaRepository,
        private readonly TricksMapper $tricksMapper,
        private readonly MediaMapper $mediaMapper
    ) { }

    /**
     * Summary of getPaginatedHomeTricks
     *
     * @param int $page  page
     * @param int $limit limit
     * 
     * @return array
     */
    public function getPaginatedHomeTricks(int $page, int $limit): array
    {
        $data = $this->trickRepository->findTricksPaginated($page, $limit);
        $data['tricks'] = $this->tricksMapper->transformToHomeTricks($data['tricks']);

        $defaultMedia = $this->mediaMapper->getMediaModel($this->mediaRepository->findOneByName('photo_default.webp'));

        foreach ($data['tricks'] as $trick) {
            if ($trick->getMedia() === null) {
                $trick->setMedia($defaultMedia);
            }
        }

        return $data;
    }

    /**
     * Summary of getTrickDetails
     *
     * @param string $slug slug
     * 
     * @return TrickDetails
     */
    public function getTrickDetails(string $slug): TrickDetails
    {
       $trick = $this->trickRepository->findOneBySlug($slug);

       return $this->tricksMapper->getTrickDetails($trick);
    }

    /**
     * Summary of isTrickNameKnown
     *
     * @param string $trickName trickName
     * 
     * @return bool
     */
    public function isTrickNameKnown(string $trickName): bool
    {
        $knownTrick = $this->trickRepository->findOneByName($trickName);

        if($knownTrick){
            return true;
        }

        return false;

    }

    /**
     * Summary of saveTrick
     *
     * @param Trick $trick Trick
     * 
     * @return void
     */
    public function saveTrick(Trick $trick): void
    {
        $this->trickRepository->saveTrick($trick);
    }

    /**
     * Summary of deleteTrick
     *
     * @param Trick $trick Trick
     * 
     * @return bool
     */
    public function deleteTrick(Trick $trick): bool
    {
        if($this->trickRepository->findOneById($trick->getId()) === null){
            return false;
        }

        $this->trickRepository->delete($trick);
        return true;
    }

}
