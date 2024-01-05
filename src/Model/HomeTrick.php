<?php

/**
 * HomeTrick File Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

use App\Model\HomeMedia;

/**
 * HomeTrick Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class HomeTrick
{
    /**
     * Summary of function __construct
     *
     * @param int        $id    Id
     * @param string     $name  Name
     * @param string     $slug  Slug
     * @param ?HomeMedia $media Media
     */
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $slug,
        private ?HomeMedia $media
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
     * Summary of function getSlug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Summary of function getMedia
     *
     * @return HomeMedia|null
     */
    public function getMedia(): ?HomeMedia
    {
        return $this->media;
    }

    /**
     * Summary of function setMedia
     *
     * @param HomeMedia $media Media
     *
     * @return static
     */
    public function setMedia(HomeMedia $media): static
    {
        $this->media = $media;

        return $this;
    }

}
