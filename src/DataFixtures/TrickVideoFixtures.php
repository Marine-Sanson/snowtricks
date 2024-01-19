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

class TrickVideoFixtures extends Fixture implements DependentFixtureInterface
{
   public function __construct(
       private readonly MediaRepository $mediaRepository,
       private readonly TypeMediaRepository $typeMediaRepository,
       private readonly FixturesService $fixturesService,
   ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 19; $i++){
            $trick = $this->getReference('trick'.$i);
            for ($j = 0; $j < mt_rand(0, 4); $j++) {
                $date = $this->fixturesService->generateCreatedAt();

                $mediaName = [
                    'https://www.youtube.com/embed/oeOcg6XHtM4',
                    'https://www.youtube.com/embed/M_BOfGX0aGs',
                    'https://www.youtube.com/embed/aJW6Kx5GzgA',
                    'https://www.youtube.com/embed/qQy8CCTQnZ4',
                    'https://www.youtube.com/embed/MnRNHpj_jwY'
                ];

                $x = mt_rand(0, 4);
                $media = (new Media())
                    ->setTypeMedia($this->typeMediaRepository->findOneByType('video'))
                    ->setName($mediaName[$x])
                    ->setCreatedAt($date)
                    ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

                $manager->persist($media);
    
                $trick->addMedium($media);
                $manager->persist($trick);
                $manager->flush();
            }
        } //end for

    }

    public function getDependencies()
    {
        return [
            TricksFixtures::class,
            TrickMediaFixtures::class,
        ];
    }
}
