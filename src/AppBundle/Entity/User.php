<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
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
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="FirstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"}, inversedBy="users")
     */
    private $tags;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", nullable=true, length=5)*
     * @Assert\Length(max = 5)
     */
    private $codePostal;

    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="user_group_relation",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")})
     */
    protected $groups;


    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="creator")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="followers")
     */
    private $eventsFollowed;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return User
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return User
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float|null $longitude
     *
     * @return User
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set codePostal.
     *
     * @param string|null $codePostal
     *
     * @return User
     */
    public function setCodePostal($codePostal = null)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal.
     *
     * @return string|null
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Add tag.
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return User
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * Remove tag.
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        return $this->tags->removeElement($tag);
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add event.
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return User
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;
        return $this;
    }
  
    /**
     * Remove event.
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        return $this->events->removeElement($event);
    }

    /**
     * Get events.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set eventsFollowed.
     *
     * @param \AppBundle\Entity\Event|null $eventsFollowed
     *
     * @return User
     */
    public function setEventsFollowed(\AppBundle\Entity\Event $eventsFollowed = null)
    {
        $this->eventsFollowed = $eventsFollowed;

        return $this;
    }

    /**
     * Get eventsFollowed.
     *
     * @return \AppBundle\Entity\Event|null
     */
    public function getEventsFollowed()
    {
        return $this->eventsFollowed;
    }

    /**
     * Add eventsFollowed.
     *
     * @param \AppBundle\Entity\Event $eventsFollowed
     *
     * @return User
     */
    public function addEventsFollowed(\AppBundle\Entity\Event $eventsFollowed)
    {
        $this->eventsFollowed[] = $eventsFollowed;

        return $this;
    }

    /**
     * Remove eventsFollowed.
     *
     * @param \AppBundle\Entity\Event $eventsFollowed
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEventsFollowed(\AppBundle\Entity\Event $eventsFollowed)
    {
        return $this->eventsFollowed->removeElement($eventsFollowed);
    }
}
