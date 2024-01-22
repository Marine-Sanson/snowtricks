<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Service\FixturesService;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GroupFixtures extends Fixture
{


    public function __construct(
        private readonly FixturesService $fixturesService,
    ) {

    }


    public function load(ObjectManager $manager): void
    {

        $date = $this->fixturesService->generateCreatedAt();
        $group1 = (new Group())
            ->setName('Grab')
            ->setDescription($this->fixturesService->faker->text(120))
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

            $this->addReference('group1', $group1);

        $manager->persist($group1);
        $manager->flush();
        
        $date = $this->fixturesService->generateCreatedAt();
        $group2 = (new Group())
            ->setName('Rotation')
            ->setDescription($this->fixturesService->faker->text(120))
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

        $this->addReference('group2', $group2);

        $manager->persist($group2);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $group3 = (new Group())
            ->setName('Flip')
            ->setDescription($this->fixturesService->faker->text(120))
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

        $this->addReference('group3', $group3);

        $manager->persist($group3);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $group4 = (new Group())
            ->setName('Slide')
            ->setDescription($this->fixturesService->faker->text(120))
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

        $this->addReference('group4', $group4);

        $manager->persist($group4);
        $manager->flush();

        $date = $this->fixturesService->generateCreatedAt();
        $group5 = (new Group())
            ->setName('Autre')
            ->setDescription($this->fixturesService->faker->text(120))
            ->setCreatedAt($date)
            ->setUpdatedAt($this->fixturesService->generateUpdatedAt($date));

        $this->addReference('group5', $group5);

        $manager->persist($group5);
        $manager->flush();

    }


}
