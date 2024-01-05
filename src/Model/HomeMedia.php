<?php

/**
 * HomeMedia File Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

/**
 * HomeMedia Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class HomeMedia
{
    /**
     * Summary of function __construct
     *
     * @param int    $id        Id
     * @param int    $typeMedia TypeMedia
     * @param string $name      Name
     */
    public function __construct(
        private int $id,
        private int $typeMedia,
        private string $name
    ) { }

    /**
     * Summary of function getId
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Summary of function getTypeMedia
     *
     * @return int
     */
    public function getTypeMedia(): int
    {
        return $this->typeMedia;
    }

    /**
     * Summary of function setTypeMedia
     *
     * @param int $typeMedia TypeMedia
     *
     * @return static
     */
    public function setTypeMedia(int $typeMedia): static
    {
        $this->typeMedia = $typeMedia;

        return $this;
    }

    /**
     * Summary of function getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Summary of function setName
     *
     * @param string $name Name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

}
