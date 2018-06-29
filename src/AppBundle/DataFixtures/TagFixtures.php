<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 edition !
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag();
            $tag->setLabel('tag' . $i);

            $manager->persist($tag);

            $this->addReference('tag' . $i, $tag);
        }

        $manager->flush();
    }
}
