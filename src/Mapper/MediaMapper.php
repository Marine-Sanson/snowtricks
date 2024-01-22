<?php

/**
 * MediaMapper File Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Mapper;

use App\Entity\Media;
use App\Model\HomeMedia;

/**
 * MediaMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class MediaMapper
{


    /**
     * Summary of getMediasModel
     *
     * @param array<Media> $medias array of medias
     *
     * @return array
     */
    public function getMediasModel(array $medias): array
    {

        return array_map(
            function (Media $media) {
                return $this->getMediaModel($media);
            },
            $medias
        );

    }


    /**
     * Summary of getTrickGroupModel
     *
     * @param Media $media Media
     *
     * @return HomeMedia
     */
    public function getMediaModel(Media $media): HomeMedia
    {

        return new HomeMedia($media->getId(), $media->getTypeMedia()->getType(), $media->getName());

    }


}
