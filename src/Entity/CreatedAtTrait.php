<?php

/**
 * CreatedAtTrait File Doc Comment
 *
 * @category Trait
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * CreatedAtTrait Class Doc Comment
 *
 * @category Trait
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
trait CreatedAtTrait
{

    /**
     * Summary of $createdAt
     *
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAt;


    /**
     * Summary of function getCreatedAt
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {

        return $this->createdAt;

    }


    /**
     * Summary of function setCreatedAt
     *
     * @param DateTimeImmutable $createdAt CreatedAt
     *
     * @return static
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {

        $this->createdAt = $createdAt;

        return $this;

    }

}
