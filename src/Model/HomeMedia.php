<?php

namespace App\Model;

class HomeMedia
{

    public function __construct(
        private int $id,
        private int $typeMedia,
        private string $url,
        private string $alt,
    ) { }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeMedia(): int
    {
        return $this->typeMedia;
    }

    public function setTypeMedia(int $typeMedia): static
    {
        $this->typeMedia = $typeMedia;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

}
