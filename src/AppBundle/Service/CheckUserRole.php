<?php

namespace AppBundle\Service;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;

class CheckUserRole
{
    public function checkUser(?User $user, Edition $edition): bool
    {
        if ($user === null) {
            return false;
        }
        $isManager = false;

        if ($user->getId() == $edition->getEvent()->getCreator()->getId()) {
            $isManager = true;
        }

        foreach ($edition->getGroups() as $group) {
            foreach ($group->getUsers() as $manager) {
                if ($user == $manager) {
                    $isManager = true;
                }
            }
        }

        return $isManager;
    }

    public function checkCreator(?User $user, Event $event): bool
    {
        if ($user === null) {
            return false;
        }
        $isCreator = false;
        $creator = $event->getCreator()->getId();
        if ($user->getId() == $creator) {
            $isCreator = true;
        }
        return $isCreator;
    }
}
