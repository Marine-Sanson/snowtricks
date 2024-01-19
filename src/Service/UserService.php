<?php

/**
 * UserService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use App\Entity\User;
use App\Model\UserModel;
use App\Mapper\UserMapper;
use App\Model\UserRegister;
use App\Model\UserProfilModel;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * UserService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class UserService
{
    /**
     * Summary of function __construct
     *
     * @param JWTService                  $jWTService         JWTService
     * @param UserRepository              $userRepository     UserRepository
     * @param EntityManagerInterface      $entityManager      EntityManagerInterface 
     * @param UserPasswordHasherInterface $userPasswordHasher UserPasswordHasherInterface 
     * @param TokenGeneratorInterface     $tokenGenerator     TokenGeneratorInterface
     * @param ParameterBagInterface       $params             ParameterBagInterface
     */
    public function __construct(
        private readonly JWTService $jWTService,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly ParameterBagInterface $params,
    ) {}

    /**
     * Summary of register
     *
     * @param UserRegister $userRegister UserRegister
     * 
     * @return string
     */
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
            $this->params->get('app.jwtsecret')
        );

    }

    /**
     * Summary of getUserVerified
     *
     * @param int $userId userId
     * 
     * @return User|null
     */
    public function getUserVerified(int $userId): ?User
    {
        $user = $this->userRepository->find($userId);

        if ($user && !$user->getIsVerified()){
            return $this->userRepository->updateIsVerify($user);
        }

        return null;
    }

    /**
     * Summary of isUserVerifiedYet
     *
     * @param User $user User
     * 
     * @return bool
     */
    public function isUserVerifiedYet(User $user): bool
    {
        return $user->getIsVerified();
    }

    /**
     * Summary of newRegisterToken
     *
     * @param UserModel $user UserModel
     * 
     * @return string
     */
    public function newRegisterToken(UserModel $user): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'userId' => $user->getId()
        ];

        return $this->jWTService->generate($header, $payload, $this->params->get('app.jwtsecret'));
    }

    /**
     * Summary of getUserModel
     *
     * @param User $user User
     * 
     * @return UserModel
     */
    public function getUserModel(User $user): UserModel
    {
        return new UserModel($user->getId(), $user->getUserIdentifier(), $user->getEmail());
    }

    /**
     * Summary of isUserKnown
     *
     * @param string $email email
     * 
     * @return UserModel|null
     */
    public function isUserKnown(string $email): ?UserModel
    {
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user){
            return null;
        }

        return $this->getUserModel($user);

    }

    /**
     * Summary of setToken
     *
     * @param UserModel $userModel UserModel
     * 
     * @return string
     */
    public function setToken(UserModel $userModel): string
    {
        $token = $this->tokenGenerator->generateToken();
        $user = $this->userRepository->find($userModel->getId());

        $user->setResetToken($token);
        $this->userRepository->saveUser($user);

        return $token;
    }

    /**
     * Summary of findUserByResetToken
     *
     * @param string $token token
     * 
     * @return UserModel
     */
    public function findUserByResetToken(string $token): UserModel
    {
        $user = $this->userRepository->findOneByResetToken($token);
        return $this->getUserModel($user);
    }

    /**
     * Summary of setNewPassword
     *
     * @param UserModel $userModel UserModel
     * @param string    $password  password
     * 
     * @return void
     */
    public function setNewPassword(UserModel $userModel, string $password): void
    {
        $user = $this->userRepository->find($userModel->getId());
        $user->setResetToken('');
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
        $this->userRepository->saveUser($user);
    }

    public function getUser(string $email): User
    {
        return $this->userRepository->findOneByEmail($email);
    }

    public function saveUser(User $user): User
    {
        return $this->userRepository->saveUser($user);
    }

}
