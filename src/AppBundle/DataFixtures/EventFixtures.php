<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Event;
use AppBundle\Service\SlugService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugService = new SlugService();
        $faker = Factory::create('fr_FR');
        // create 20 event !
        for ($i = 0; $i < 20; $i++) {
            $event = new Event();
            $event->setTitle(ucfirst($faker->words(3, true)));
            $event->setCity($faker->city);
            $event->setDescription($faker->text);
            $event->setImageName('image.jpg');
            $event->setSlug($slugService->generateSlug($event->getTitle()));
            $manager->persist($event);
        }

        $manager->flush();
    }
}
