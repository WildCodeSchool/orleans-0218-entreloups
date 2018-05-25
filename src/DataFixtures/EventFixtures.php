<?php

namespace AppFixtures\DataFixtures;

use AppBundle\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 event !
        for ($i = 0; $i < 20; $i++) {
            $event = new Event();
            $event->setTitle('Title ' . $i);
            $event->setCity('Orléans ' . $i);
            $event->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.
             Praesent interdum, metus id malesuada tempor, velit neque ullamcorper tortor, 
             vel sollicitudin est orci id metus. Curabitur rutrum quam massa, nec porttitor risus euismod quis. 
             Praesent sit amet sollicitudin diam. Sed tincidunt sapien nec rhoncus ullamcorper. 
             Etiam tempus eleifend nulla, vitae scelerisque.');
            $event->setImage('image.jpg');
            $manager->persist($event);
        }

        $manager->flush();
    }
}

