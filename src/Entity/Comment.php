<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Trick;
use DateTimeImmutable;
use App\Entity\CreatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

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
     * Summary of function getContent
     *
     * @return string
     */
    public function getContent(): string
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
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Summary of getTricks
     *
     * @return Trick|null
     */
    public function getTrick(): Trick
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
    public function setTrick(Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Summary of getAuthor
     *
     * @return User|null
     */
    public function getAuthor(): User
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
    public function setAuthor(User $author): static
    {
        $this->author = $author;

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
