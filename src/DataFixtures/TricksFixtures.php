<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Service\FixturesService;
use App\Repository\MediaRepository;
use App\Repository\TypeMediaRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class TricksFixtures extends Fixture implements DependentFixtureInterface
{
   public function __construct(
       private readonly MediaRepository $mediaRepository,
       private readonly TypeMediaRepository $typeMediaRepository,
       private readonly FixturesService $fixturesService,
       private readonly SluggerInterface $slugger,
   ) {}

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 19; $i++) {
            $date = $this->fixturesService->generateCreatedAt();
            $trickName = $this->fixturesService->faker->words(mt_rand(1, 3), true);
            $slug = $this->slugger->slug($trickName);
            $trick = (new Trick())
                ->setName($trickName)
                ->setDescription($this->fixturesService->faker->paragraphs(mt_rand(3, 8), true))
                ->setSlug($slug)
                ->setCreatedAt($date)
                ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

            for ($j = 1; $j < mt_rand(1, 3); $j++)
            {
                $k = mt_rand(1, 5);
                $trick->addTrickGroup($this->getReference('group' . $k));
            }

            $ref = 'trick' . $i;
            $this->addReference($ref, $trick);

            $manager->persist($trick);
            $manager->flush();
        }//end for

    }

    public function getDependencies()
    {
        return [
            GroupFixtures::class,
        ];
    }
}
