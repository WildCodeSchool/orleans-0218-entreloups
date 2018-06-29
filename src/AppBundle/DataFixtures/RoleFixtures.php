<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EditionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sponsor = new Role();
        $sponsor->setLabel('Sponsor');
        $this->addReference('sponsor', $sponsor);
        $manager->persist($sponsor);

        $partenaire = new Role();
        $partenaire->setLabel('Partenaire');
        $this->addReference('partenaire', $partenaire);
        $manager->persist($partenaire);

        $manager->flush();
    }
}
