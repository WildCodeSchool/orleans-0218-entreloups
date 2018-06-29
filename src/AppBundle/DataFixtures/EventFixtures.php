<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Event;
use AppBundle\Service\SlugService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $slugService = new SlugService();
        $faker = Factory::create('fr_FR');
        $nbEvent = 0;
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $event = new Event();
                $event->setTitle(ucfirst($faker->words(3, true)));
                $event->setCity($faker->city);
                $event->setDescription($faker->text);
                $event->setImageName('image.jpg');
                $event->setSlug($slugService->generateSlug($event->getTitle()));
                $event->setCreator($this->getReference('user' . $i));
                $event->addTag($this->getReference('tag' . $j, $event));
                $event->addTag($this->getReference('tag' . ($j + 1), $event));
                $event->addTag($this->getReference('tag' . ($j + 2), $event));
                $event->addTag($this->getReference('tag' . ($j + 3), $event));
                $event->addTag($this->getReference('tag' . ($j + 4), $event));
                $manager->persist($event);
                $this->addReference('event' . $nbEvent, $event);
                $nbEvent++;
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TagFixtures::class,
        );
    }
}
