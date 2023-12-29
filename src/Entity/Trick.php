<?php

namespace App\Entity;

use App\Entity\Group;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrickRepository;
use App\Entity\CreatedAtTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du trick ne peut pas être vide et doit être unique')]
    #[Assert\Length(
        min: 5,
        minMessage: 'Le nom du trick doit contenir au moins {{ limit }} caractères',
        max: 50,
        maxMessage: 'Le nom du trick ne doit pas faire plus de {{ limit }} caractères')]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description du trick ne peut pas être vide')]
    private string $description;

    #[ORM\Column(length: 50)]
    private string $slug;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'tricks')]
    private Collection $trickGroup;

    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'tricks', cascade:['persist'])]
    private Collection $media;

    public function __construct()
    {
        $this->trickGroup = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getTrickGroup(): Collection
    {
        return $this->trickGroup;
    }

    public function addTrickGroup(Group $trickGroup): static
    {
        if (!$this->trickGroup->contains($trickGroup)) {
            $this->trickGroup->add($trickGroup);
        }

        return $this;
    }

    public function removeTrickGroup(Group $trickGroup): static
    {
        $this->trickGroup->removeElement($trickGroup);

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        $this->media->removeElement($medium);

        return $this;
    }
}
