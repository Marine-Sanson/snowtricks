<?php

namespace App\Model;

use App\Model\HomeMedia;

class HomeTrick
{

    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $slug,
        private readonly ?HomeMedia $media
    ) { }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return HomeMedia
     */
    public function getMedia(): ?HomeMedia
    {
        return $this->media;
    }

}
