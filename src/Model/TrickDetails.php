<?php

/**
 * TrickDetails File Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

use DateTimeImmutable;
use App\Model\HomeGroup;
use App\Model\HomeMedia;

/**
 * TrickDetails Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class TrickDetails
{

    /**
     * Summary of function __construct
     *
     * @param int               $id          Id
     * @param string            $name        Name
     * @param string            $description Description
     * @param string            $slug        Slug
     * @param DateTimeImmutable $updatedAt   UpdatedAt
     * @param array             $trickGroup  TrickGroup
     * @param array             $media       Media
     * @param HomeMedia         $mainMedia   HomeMedia
     */
        public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $slug,
        private readonly DateTimeImmutable $updatedAt,
        private readonly array $trickGroup,
        private readonly array $media,
        private readonly HomeMedia $mainMedia
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
     * Summary of function getDescription
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Summary of function getSlug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Summary of function getUpdatedAt
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Summary of getTrickGroup
     *
     * @return array<HomeGroup>
     */
    public function getTrickGroup(): array
    {
        return $this->trickGroup;
    }

    /**
     * Summary of getMedia
     *
     * @return array<HomeMedia>
     */
    public function getMedia(): array
    {
        return $this->media;
    }

    /**
     * Summary of getMainMedia
     *
     * @return HomeMedia
     */
    public function getMainMedia(): HomeMedia
    {
        return $this->mainMedia;
    }

}
