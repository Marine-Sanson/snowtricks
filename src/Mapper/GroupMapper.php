<?php

namespace App\Mapper;

use App\Entity\Group;
use App\Model\HomeGroup;

class GroupMapper
{

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

}
