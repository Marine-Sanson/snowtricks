<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Media;
use App\Service\FixturesService;
use App\Repository\MediaRepository;
use App\Repository\TypeMediaRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
;

class UserFixtures extends Fixture implements DependentFixtureInterface
{


    /**
     * @param UserPasswordHasherInterface $userPasswordHasher  UserPasswordHasherInterface
     * @param MediaRepository             $mediaRepository     MediaRepository
     * @param TypeMediaRepository         $typeMediaRepository TypeMediaRepository
     * @param FixturesService             $fixturesService     FixturesService
     */
   public function __construct(
       private readonly UserPasswordHasherInterface $userPasswordHasher,
       private readonly MediaRepository $mediaRepository,
       private readonly TypeMediaRepository $typeMediaRepository,
       private readonly FixturesService $fixturesService,
   ) {

   }


    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 15; $i++) {
            $date = $this->fixturesService->generateCreatedAt();

            $mediaName = 'avatar-'.mt_rand(1, 16).'.webp';
            $media = (new Media())
                ->setTypeMedia($this->typeMediaRepository->findOneByType('avatar'))
                ->setName($mediaName)
                ->setCreatedAt($date)
                ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
                
            $manager->persist($media);
            $manager->flush();

            $date = $this->fixturesService->generateCreatedAt();
            $role = ["ROLE_USER"];
            $x = mt_rand(0, 9);

            if ($x === 7) {
                $role = ["ROLE_ADMIN"];
            }

            $user = (new User())
                ->setEmail($this->fixturesService->faker->email())
                ->setRoles($role)
                ->setUsername($this->fixturesService->faker->username())
                ->setIsVerified(true)
                ->setResetToken(null)
                ->setCreatedAt($date)
                ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date))
                ->setAvatar($media);
        
            $password = $this->userPasswordHasher->hashPassword($user, 'mdpass');
            $user->setPassword($password);
            
            $ref = 'user'.$i;
            $this->addReference($ref, $user);

            $manager->persist($user);
            $manager->flush();
        } //end for

    }


    public function getDependencies()
    {

        return [
            AppFixtures::class,
        ];

    }

}
