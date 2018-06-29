<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($nbEdition = 1; $nbEdition < 60; $nbEdition++) {
            for ($i = 0; $i < 3; $i++) {
                $task = new Task();
                $task->setName('task' . $i);
                $task->setStatus('A faire');
                $task->setDescription($faker->sentence(random_int(6, 25)));
                $task->setDeadline(DateTime::dateTime());
                $task->setEdition($this->getReference('edition' . $nbEdition));

                $manager->persist($task);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            EditionFixtures::class,
        );
    }
}
