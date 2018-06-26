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
use FOS\UserBundle\Model\UserInterface;

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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     *
     */
    protected $users;

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

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        return $this->users ?: $this->users = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getUserUsername()
    {
        $usernames = array();
        foreach ($this->getUsers() as $user) {
            $usernames[] = $user->getUsername();
        }

        return $usernames;
    }

    /**
     * {@inheritdoc}
     */
    public function hasUser($username)
    {
        return in_array($username, $this->getUserUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function addUser(UserInterface $user)
    {
        if (!$this->getUsers()->contains($user)) {
            $this->getUsers()->add($user);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeUser(UserInterface $user)
    {
        if ($this->getUsers()->contains($user)) {
            $this->getUsers()->removeElement($user);
        }

        return $this;
    }
}
