<?php

/**
 * Group File Doc Comment
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
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group Class Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
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
    #[Assert\NotBlank(message: 'Le nom du groupe ne peut pas être vide')]
    private string $name;

    /**
     * Summary of description
     *
     * @var string
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description du groupe ne peut pas être vide')]
    private string $description;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    /**
     * Summary of tricks
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Trick::class, mappedBy: 'trickGroup')]
    private Collection $tricks;


    /**
     * Summary of function __construct
     */
    public function __construct()
    {

        $this->tricks = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();

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
     * Summary of function getTricks
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
            $trick->addTrickGroup($this);
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
            $trick->removeTrickGroup($this);
        }

        return $this;

    }


}
