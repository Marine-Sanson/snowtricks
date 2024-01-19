<?php

/**
 * TricksMapper File Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Mapper;

use App\Entity\Trick;
use App\Model\HomeMedia;
use App\Model\HomeTrick;
use App\Mapper\GroupMapper;
use App\Mapper\MediaMapper;
use App\Model\TrickDetails;
use App\Repository\MediaRepository;

/**
 * TricksMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TricksMapper
{
    /**
     * Summary of function __construct
     *
     * @param MediaMapper     $mediaMapper     MediaMapper
     * @param GroupMapper     $groupMapper     GroupMapper
     * @param MediaRepository $mediaRepository MediaRepository
     */
    public function __construct(
        private readonly MediaMapper $mediaMapper,
        private readonly GroupMapper $groupMapper,
        private readonly MediaRepository $mediaRepository,
    ) { }

    /**
     * Summary of transformToHomeTricks
     *
     * @param array<Trick> $trick array of tricks
     *
     * @return array
     */
    public function transformToHomeTricks(array $tricks): array
    {
        return array_map(
            function (Trick $trick) {
                return $this->getHomeTrick($trick);
            },
            $tricks
        );
    }

    /**
     * Summary of getHomeTrick
     *
     * @param Trick $trick Trick
     *
     * @return HomeTrick
     */
    public function getHomeTrick(Trick $trick): HomeTrick
    {
        $media = null;

        $allMedias = $trick->getMedia();

        if ($allMedias[0] !== null) {
            $media = $this->mediaMapper->getMediaModel($allMedias[0]);
        }

        return new HomeTrick(
            $trick->getId(),
            $trick->getName(),
            $trick->getSlug(),
            $media
        );

    }

    /**
     * Summary of transformToTrickDetails
     *
     * @param array<Trick> $trick array of tricks
     *
     * @return array
     */
    public function transformToTricksDetails(array $tricks): array
    {
        return array_map(
            function (Trick $trick) {
                return $this->getTrickDetails($trick);
            },
            $tricks
        );
    }

    /**
     * Summary of getTrickDetails
     *
     * @param Trick $trick Trick
     *
     * @return TrickDetails
     */
    public function getTrickDetails(Trick $trick): TrickDetails
    {

        $updatedAt = $trick->getUpdatedAt();

        $trickGroup = $trick->getTrickGroup()->toArray();
        $trickGroupModel = $this->groupMapper->getTrickGroupModel($trickGroup);

        $medias = $trick->getMedia()->toArray();
        $mediasModel = $this->mediaMapper->getMediasModel($medias);

        $mainMedia = $this->getMainMedia($mediasModel);

        return new TrickDetails(
            $trick->getId(),
            $trick->getName(),
            $trick->getDescription(),
            $trick->getSlug(),
            $updatedAt,
            $trickGroupModel,
            $mediasModel,
            $mainMedia
        );
    }

    /**
     * Summary of getPaginatedHomeTricks
     *
     * @param array<HomeMedia> $mediasModel  HomeMedia
     * 
     * @return HomeMedia
     */
    public function getMainMedia($mediasModel): HomeMedia
    {
        $homeMedia = null;
        for ($i = 0, $count = count($mediasModel); $i < $count; $i++) {

            if ($mediasModel[$i]->getTypeMedia() === 'photo'){
                $homeMedia = $mediasModel[$i];

                if ($homeMedia !== null){
                    return $homeMedia;
                }

            }   

        }

        if ($homeMedia === null){
            $homeMedia = $this->mediaMapper->getMediaModel($this->mediaRepository->findOneByName('photo_default.webp'));
        }

        return $homeMedia;
    }

}
