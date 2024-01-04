<?php

/**
 * TypeMedia File Doc Comment
 *
 * PHP Version 8.3.1
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CreatedAtTrait;
use App\Repository\TypeMediaRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TypeMedia Class Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[ORM\Entity(repositoryClass: TypeMediaRepository::class)]
class TypeMedia
{
    use CreatedAtTrait;

    /**
     * Summary of id
     *
     * @var integer|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Summary of type
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $type = null;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * Summary of media
     *
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'typeMedia', targetEntity: Media::class)]
    private Collection $media;

    /**
     * Summary of function __construct
     */
    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * Summary of function getId
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of function getType
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Summary of function setType
     *
     * @param string $type Type
     *
     * @return static
     */
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Summary of function getUpdatedAt
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Summary of function setUpdatedAt
     *
     * @param DateTimeImmutable $updatedAt UpdatedAt
     *
     * @return static
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Summary of getMedia
     *
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    /**
     * Summary of function addMedium
     *
     * @param Media $medium Media
     *
     * @return static
     */
    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setTypeMedia($this);
        }

        return $this;
    }

    /**
     * Summary of function removeMedium
     *
     * @param Media $medium Media
     *
     * @return static
     */
    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getTypeMedia() === $this) {
                $medium->setTypeMedia(null);
            }
        }

        return $this;
    }

}
