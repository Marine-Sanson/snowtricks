<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Service\FixturesService;
use App\Repository\MediaRepository;
use App\DataFixtures\TricksFixtures;
use App\Repository\TypeMediaRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickMediaFixtures extends Fixture implements DependentFixtureInterface
{
   public function __construct(
       private readonly MediaRepository $mediaRepository,
       private readonly TypeMediaRepository $typeMediaRepository,
       private readonly FixturesService $fixturesService,
   ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 19; $i++){
            $trick = $this->getReference('trick' . $i);
            for ($j = 0; $j < mt_rand(0, 12); $j++) {
                $date = $this->fixturesService->generateCreatedAt();

                $mediaName = 'photo-' . mt_rand(1, 28) . '.webp';
    
                $media = (new Media())
                    ->setTypeMedia($this->typeMediaRepository->findOneByType('photo'))
                    ->setName($mediaName)
                    ->setCreatedAt($date)
                    ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

                $manager->persist($media);
    
                $trick->addMedium($media);
                $manager->persist($trick);
                $manager->flush();
            }
        }

    }

    public function getDependencies()
    {
        return [
            TricksFixtures::class,
        ];
    }
}
