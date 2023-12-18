<?php

namespace App\Mapper;

use App\Entity\Media;
use App\Model\HomeMedia;

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

    public function getMediaModel(Media $media): HomeMedia
    {
        return new HomeMedia($media->getId(), $media->getTypeMedia()->getId(), $media->getUrl(), $media->getAlt());
    }

}
