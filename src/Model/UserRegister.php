<?php

/**
 * UserRegister File Doc Comment
 *
 * PHP Version 8.3.1
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Model;

/**
 * UserRegister Class Doc Comment
 *
 * @category Model
 * @package  App\Model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class UserRegister
{
    /**
     * Summary of function __construct
     *
     * @param string $username      Username
     * @param string $email         Email
     * @param string $plainPassword PlainPassword
     */
    public function __construct(
        private readonly string $username,
        private readonly string $email,
        private readonly string $plainPassword
    ) {}

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

    /**
     * Summary of function getPlainPassword
     *
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Summary of function setPlainPassword
     *
     * @param string $plainPassword PlainPassword
     *
     * @return static
     */
    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

}
