<?php

namespace App\Mapper;

use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Trick;
use App\Model\HomeGroup;
use App\Model\HomeMedia;
use App\Model\HomeTrick;

class TricksMapper
{

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

    public function getHomeTrick(Trick $trick): HomeTrick
    {

        $creationDate = $trick->getUpdatedAt();

        $trickGroup = $trick->getTrickGroup()->toArray();
        $trickGroupModel = $this->getTrickGroupModel($trickGroup);

        $medias = $trick->getMedia()->toArray();
        $mediasModel = $this->getMediasModel($medias);
        
        return new HomeTrick(
            $trick->getId(),
            $trick->getName(),
            $trick->getDescription(),
            $trick->getSlug(),
            $creationDate,
            $trickGroupModel,
            $mediasModel
        );
    }

    /**
     * Summary of getTrickGroupModel
     *
     * @param array<Group> $trickgroup array of trickgroups
     *
     * @return array
     */
    public function getTrickGroupModel(array $trickgroup): array
    {
        return array_map(
            function (Group $group) {
                return $this->getGroupModel($group);
            },
            $trickgroup
        );
    }

    public function getGroupModel(Group $group): HomeGroup
    {
        return new HomeGroup($group->getId(), $group->getName());
    }

    /**
     * Summary of getTrickGroupModel
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
