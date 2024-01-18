<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\TypeMedia;
use App\Repository\MediaRepository;
use App\Repository\TypeMediaRepository;
use App\Service\FixturesService;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly MediaRepository $mediaRepository,
        private readonly TypeMediaRepository $typeMediaRepository,
        private readonly FixturesService $fixturesService,
    ) { }

    public function load(ObjectManager $manager): void
    {
        $date = $this->fixturesService->generateCreatedAt();

        $typeMedia1 = (new TypeMedia())
            ->setType('photo')
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
        $manager->persist($typeMedia1);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $typeMedia2 = (new TypeMedia())
            ->setType('video')
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
        $manager->persist($typeMedia2);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $typeMedia3 = (new TypeMedia())
            ->setType('avatar')
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
        $manager->persist($typeMedia3);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $media1 = (new Media())
            ->setTypeMedia($this->typeMediaRepository->findOneByType('photo'))
            ->setName('photo_default.webp')
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
        
        $manager->persist($media1);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $media2 = (new Media())
            ->setTypeMedia($this->typeMediaRepository->findOneByType('avatar'))
            ->setName('avatar_default.webp')
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));
        
        $manager->persist($media2);
        $manager->flush();

    }

}
