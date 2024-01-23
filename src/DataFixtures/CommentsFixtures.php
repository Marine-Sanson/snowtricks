<?php

namespace App\DataFixtures;

use App\Service\FixturesService;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TricksFixtures;
use App\Entity\Comment;
use App\Repository\TypeMediaRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentsFixtures extends Fixture implements DependentFixtureInterface
{


    /**
     * Summary of function __construct
     *
     * @param TypeMediaRepository $typeMediaRepository TypeMediaRepository
     * @param FixturesService     $fixturesService     FixturesService
     */
    public function __construct(
        private readonly TypeMediaRepository $typeMediaRepository,
        private readonly FixturesService $fixturesService,
    ) {

    }


    /**
     * Summary of function load
     *
     * @param ObjectManager $manager ObjectManager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 19; $i++) {
            $trick = $this->getReference('trick'.$i);

            for ($j = 0; $j < mt_rand(8, 19); $j++) {
                $date = $this->fixturesService->generateCreatedAt();
                $x = mt_rand(0, 14);
                $comment = (new Comment())
                    ->setContent($this->fixturesService->faker->paragraphs(mt_rand(1, 3), true))
                    ->setAuthor($this->getReference('user'.$x))
                    ->setCreatedAt($date)
                    ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date))
                    ->setTrick($trick);

                $manager->persist($comment);

                $manager->flush();
            }
        }

    }


    /**
     * Summary of function getDependencies
     *
     * @return array
     */
    public function getDependencies()
    {

        return [
            TricksFixtures::class,
            UserFixtures::class,
        ];

    }


}
