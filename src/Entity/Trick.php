<?php

/**
 * Trick File Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Entity;

use App\Entity\Group;
use DateTimeImmutable;
use App\Entity\CreatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrickRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trick Class Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
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
    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du trick ne peut pas être vide et doit être unique')]
    #[Assert\Length(
        min: 5,
        minMessage: 'Le nom du trick doit contenir au moins {{ limit }} caractères',
        max: 50,
        maxMessage: 'Le nom du trick ne doit pas faire plus de {{ limit }} caractères')]
    private string $name;

    /**
     * Summary of description
     *
     * @var string
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description du trick ne peut pas être vide')]
    private string $description;

    /**
     * Summary of slug
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    /**
     * Summary of trickGroup
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'tricks')]
    private Collection $trickGroup;

    /**
     * Summary of media
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'tricks', cascade:['persist'])]
    private Collection $media;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    /**
     * Summary of function __construct
     */
    public function __construct()
    {
        $this->trickGroup = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->comments = new ArrayCollection();
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
     * Summary of function getDescription
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Summary of function setDescription
     *
     * @param string $description Description
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Summary of function getSlug
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Summary of function setSlug
     *
     * @param string $description Description
     *
     * @return static
     */
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
     * Summary of getTrickGroup
     *
     * @return Collection<int, Group>
     */
    public function getTrickGroup(): Collection
    {
        return $this->trickGroup;
    }

    /**
     * Summary of function addTrickGroup
     *
     * @param Group $trickGroup TrickGroup
     *
     * @return static
     */
    public function addTrickGroup(Group $trickGroup): static
    {
        if (!$this->trickGroup->contains($trickGroup)) {
            $this->trickGroup->add($trickGroup);
        }

        return $this;
    }

    /**
     * Summary of function removeTrickGroup
     *
     * @param Group $trickGroup TrickGroup
     *
     * @return static
     */
    public function removeTrickGroup(Group $trickGroup): static
    {
        $this->trickGroup->removeElement($trickGroup);

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
        $this->media->removeElement($medium);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick($this);
            }
        }

        return $this;
    }

}
