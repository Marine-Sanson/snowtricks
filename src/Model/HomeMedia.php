<?php

namespace App\Model;

class HomeMedia
{

    public function __construct(
        private int $id,
        private int $typeMedia,
        private string $name
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

}
