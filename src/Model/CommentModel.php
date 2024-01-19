<?php

namespace App\Model;

use App\Entity\User;
use App\Entity\Trick;
use DateTimeImmutable;

class CommentModel
{

    /**
     * Summary of id
     *
     * @var integer|null
     */
    private readonly ?int $id;

    /**
     * Summary of trick
     *
     * @var Trick|null
     */
    private ?Trick $trick;

    /**
     * Summary of author
     *
     * @var User|null
     */
    private ?User $author;

    /**
     * Summary of content
     *
     * @var string|null
     */
    private ?string $content;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $updatedAt;
    
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
     * Summary of getTricks
     *
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    /**
     * Summary of function setTrick
     *
     * @param Trick|null $trick Trick
     *
     * @return static
     */
    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Summary of getAuthor
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Summary of function setAuthor
     *
     * @param User|null $author Author
     *
     * @return static
     */
    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Summary of function getContent
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Summary of function setContent
     *
     * @param string|null $content Content
     *
     * @return static
     */
    public function setContent(?string $content): static
    {
        $this->content = $content;

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

}
