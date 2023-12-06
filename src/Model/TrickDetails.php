<?php

namespace App\Model;

use App\Model\HomeGroup;
use App\Model\HomeMedia;

class TrickDetails
{

    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private string $slug,
        private \DateTimeInterface $updatedAt,
        private array $trickGroup,
        private array $media
    ) { }

    public function getId(): int
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

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return array<HomeGroup>
     */
    public function getTrickGroup(): array
    {
        return $this->trickGroup;
    }

    /**
     * @return array<HomeMedia>
     */
    public function getMedia(): array
    {
        return $this->media;
    }

}
