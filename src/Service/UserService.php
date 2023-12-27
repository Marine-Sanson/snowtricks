<?php

namespace App\Service;

use App\Entity\User;
use App\Model\UserModel;
use App\Model\UserRegister;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class UserService
{
    public function __construct(
        private readonly JWTService $jWTService,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly ParameterBagInterface $params
    ) {}

    public function register(UserRegister $userRegister): string
    {
        $user = (new User())
            ->setUsername($userRegister->getUsername())
            ->setEmail($userRegister->getEmail());

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $userRegister->getPlainPassword()
            )
        );

        $userCreated = $this->userRepository->saveUser($user);

        $payload = [
            'userId' => $userCreated->getId()
        ];

        return $this->jWTService->generate(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            $payload,
            $this->params->get('app.jwtsecret'),
            $userCreated->getId()
        );

    }

    public function getUserVerified(int $userId): ?User
    {
        $user = $this->userRepository->find($userId);

        if ($user && !$user->getIsVerified()){
            return $this->userRepository->updateIsVerify($user);
        }

        return null;
    }

    public function isUserVerifiedYet(User $user): bool
    {
        return $user->getIsVerified();
    }

    public function newRegisterToken(UserModel $user): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'userId' => $user->getId()
        ];

        return $this->jWTService->generate($header, $payload, $this->params->get('app.jwtsecret'), $user->getId());
    }

    public function getUserModel(User $user): UserModel
    {
        return new UserModel($user->getId(), $user->getUsername(), $user->getEmail());
    }

    public function isUserKnown(string $email): UserModel
    {
        $user = $this->userRepository->findOneByEmail($email);
        return $this->getUserModel($user);
    }

    public function setToken(UserModel $userModel): string
    {
        $token = $this->tokenGenerator->generateToken();
        $user = $this->userRepository->find($userModel->getId());

        $user->setResetToken($token);
        $this->userRepository->saveUser($user);

        return $token;
    }

    public function findUserByResetToken(string $token): UserModel
    {
        $user = $this->userRepository->findOneByResetToken($token);
        return $this->getUserModel($user);
    }

    public function setNewPassword(UserModel $userModel, string $password): void
    {
        $user = $this->userRepository->find($userModel->getId());
        $user->setResetToken(' ');
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
        $this->userRepository->saveUser($user);
    }

}
