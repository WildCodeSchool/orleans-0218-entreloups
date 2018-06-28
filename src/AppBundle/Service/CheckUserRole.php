<?php

namespace AppBundle\Service;

use AppBundle\Entity\Edition;
use AppBundle\Entity\User;

class CheckUserRole
{
    public function checkUser(?User $user, Edition $edition): bool
    {
        if ($user === null) {
            return false;
        }
        $isManager = false;

        foreach ($edition->getGroups() as $group) {
            foreach ($group->getUsers() as $manager) {
                if ($user == $manager) {
                    $isManager = true;
                }
            }
        }

        return $isManager;
    }
}
