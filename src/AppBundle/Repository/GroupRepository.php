<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 25/06/18
 * Time: 14:58
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Edition;

class GroupRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByEdition(Edition $edition)
    {
        return $this->createQueryBuilder('g')
            ->join('g.edition', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $edition->getId())
            ->getQuery()
            ->getResult();
    }
}
