<?php

/**
 * GroupMapper File Doc Comment
 *
 * PHP Version 8.3.1
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Mapper;

use App\Entity\Group;
use App\Model\HomeGroup;

/**
 * GroupMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\Mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
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

    /**
     * Summary of getGroupModel
     *
     * @param Group $group Group
     *
     * @return HomeGroup
     */
    public function getGroupModel(Group $group): HomeGroup
    {
        return new HomeGroup($group->getId(), $group->getName());
    }

}
