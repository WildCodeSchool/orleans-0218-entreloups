<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setLastName('user' . $i);
            $user->setFirstName('user' . $i);
            $user->setEnabled(1);
            $user->setUsername('user' . $i);
            $user->setUsernameCanonical('user' . $i);
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setEmailCanonical('user' . $i . '@gmail.com');
            $user->setCity('Meung-sur-Loire');
            $user->setLatitude(47.8286);
            $user->setLongitude(1.69829);
            $user->setCodePostal('45130');
            $user->setPlainPassword('azerty');
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }

        $manager->flush();
    }
}
