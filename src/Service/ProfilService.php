<?php

namespace App\Service;

use App\Entity\User;
use App\Model\UserModel;
use App\Model\UserRegister;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProfilService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

}