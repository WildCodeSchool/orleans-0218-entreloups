<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Edition;
use AppBundle\Service\SlugService;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EditionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $slugService = new SlugService();
        $faker = Factory::create('fr_FR');
        $nbEdition = 0;
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $edition = new Edition();
                $edition->setEvent($this->getReference('event' . $i));
                $edition->setName(ucfirst($faker->words(3, true)));
                $edition->setStartDate(new DateTime('2018-06-26 12:00:00'));
                $edition->setEndDate(new DateTime('2018-06-30 12:00:00'));
                $edition->setPlace($faker->city);
                $edition->setHashtag($faker->word);
                $edition->setStatus(1);
                $edition->setSlug(
                    $this->getReference('event' . $i)->getTitle() . '_' .
                    $slugService->generateSlug($edition->getName())
                );

                $this->addReference('edition' . $nbEdition, $edition);

                $manager->persist($edition);
                $nbEdition++;
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            EventFixtures::class,
        );
    }
}
