<?php

namespace App\Model;

use App\Model\HomeGroup;
use App\Model\HomeMedia;

class HomeTrick
{

    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $slug,
        private readonly \DateTimeInterface $updatedAt,
        private readonly array $trickGroup,
        private readonly array $media
    ) { }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
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
