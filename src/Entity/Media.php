<?php

/**
 * Media File Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\CreatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Media Class Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
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
     * Summary of name
     *
     * @var string
     */
    #[ORM\Column(length: 50)]
    private string $name;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    /**
     * Summary of TypeMedia
     *
     * @var ?TypeMedia
     */
    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMedia $typeMedia = null;

    /**
     * Summary of tricks
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Trick::class, mappedBy: 'media')]
    private Collection $tricks;


    /**
     * Summary of function __construct
     */
    public function __construct()
    {

        $this->tricks = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = $this->createdAt;

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
     * Summary of function getTypeMedia
     *
     * @return TypeMedia
     */
    public function getTypeMedia(): ?TypeMedia
    {

        return $this->typeMedia;

    }

    /**
     * Summary of function setTypeMedia
     *
     * @param TypeMedia $typeMedia TypeMedia
     *
     * @return static
     */
    public function setTypeMedia(?TypeMedia $typeMedia): static
    {

        $this->typeMedia = $typeMedia;

        return $this;

    }


    /**
     * Summary of getTricks
     *
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {

        return $this->tricks;

    }


    /**
     * Summary of function addTrick
     *
     * @param Trick $trick Trick
     *
     * @return static
     */
    public function addTrick(Trick $trick): static
    {

        if (!$this->tricks->contains($trick)) {
            $this->tricks->add($trick);
            $trick->addMedium($this);
        }

        return $this;

    }


    /**
     * Summary of function removeTrick
     *
     * @param Trick $trick Trick
     *
     * @return static
     */
    public function removeTrick(Trick $trick): static
    {

        if ($this->tricks->removeElement($trick)) {
            $trick->removeMedium($this);
        }

        return $this;

    }


}
