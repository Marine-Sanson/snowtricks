<?php

/**
 * User File Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * User Class Doc Comment
 *
 * @category Entity
 * @package  App\Entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
     * Summary of email
     *
     * @var string
     */
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Vous devez rentrer un email')]
    private string $email;

    /**
     * Summary of roles
     *
     * @var array
     */
    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * Summary of password
     *
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    /**
     * Summary of username
     *
     * @var string
     */
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Vous devez rentrer un email')]
    private string $username;

    /**
     * Summary of isVerified
     *
     * @var bool
     */
    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * Summary of resetToken
     *
     * @var string|null
     */
    #[ORM\Column(length: 100)]
    private ?string $resetToken = null;

    /**
     * Summary of updatedAt
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Media $avatar = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable;
        $this->updatedAt = new DateTimeImmutable;
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
     * Summary of function getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Summary of function setEmail
     *
     * @param string $email Email
     *
     * @return static
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Summary of function getUserIdentifier
     *
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Summary of function getRoles
     *
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Summary of function setRoles
     *
     * @param array $roles Roles
     *
     * @return static
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Summary of function getPassword
     *
     * @see PasswordAuthenticatedUserInterface
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Summary of function setPassword
     *
     * @param string $password Password
     *
     * @return static
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Summary of function eraseCredentials
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Summary of function getType
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->username;
    }

    /**
     * Summary of function setUsername
     *
     * @param string $username Username
     *
     * @return static
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Summary of function getIsVerified
     *
     * @return bool|null
     */
    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * Summary of function setIsVerified
     *
     * @param bool $isVerified IsVerified
     *
     * @return static
     */
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Summary of function getResetToken
     *
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * Summary of function setResetToken
     *
     * @param string|null $resetToken ResetToken
     *
     * @return static
     */
    public function setResetToken(?string $resetToken): static
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * Summary of function getUpdatedAt
     *
     * @return DateTimeImmutable|null
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

    public function getAvatar(): ?Media
    {
        return $this->avatar;
    }

    public function setAvatar(?Media $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
