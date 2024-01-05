<?php

/**
 * HomeGroup File Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

/**
 * HomeGroup Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class HomeGroup
{
    /**
     * Summary of __construct
     *
     * @param int    $id   Id
     * @param string $name Name
     */
    public function __construct(
        private int $id,
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
