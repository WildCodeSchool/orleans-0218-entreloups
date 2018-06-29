<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Notification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;

class NotificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($nbEdition = 1; $nbEdition < 60; $nbEdition++) {
            for ($i = 0; $i < 3; $i++) {
                $notification = new Notification();
                $notification->setContent($faker->sentence(random_int(6, 10)));
                $notification->setPublicationTime(DateTime::dateTime());
                $notification->setEdition($this->getReference('edition' . $nbEdition));

                $manager->persist($notification);
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
