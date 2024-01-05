<?php

/**
 * UserModel File Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

/**
 * UserModel Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class UserModel
{
    /**
     * Summary of function __construct
     *
     * @param int    $id       Id
     * @param string $username Username
     * @param string $email    Email
     */
    public function __construct(
        private readonly int $id,
        private readonly string $username,
        private readonly string $email
    ) {}

    /**
     * Summary of function getId
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Summary of function setId
     *
     * @param int $id id
     *
     * @return static
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Summary of function getUsername
     *
     * @return string
     */
    public function getUsername(): string
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

}
