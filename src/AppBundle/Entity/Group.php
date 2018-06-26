<?php
/**
 * Created by PhpStorm.
 * User: aragorn
 * Date: 25/06/18
 * Time: 14:51
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * Group
 *
 * @ORM\Table(name="`group`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Edition", inversedBy="groups")
     */
    protected $edition;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Group
     */
    public function setId(int $id): Group
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * @param mixed $edition
     * @return Group
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
        return $this;
    }
}
