<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @Groups({"public"})
     *
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Length(min="3", minMessage="Tag trop court", max="255", maxMessage="Tag trop long")
     */
    private $label;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Event", cascade={"persist"}, mappedBy="tags")
     */
    private $events;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Tag
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function __toString()
    {
        return $this->label;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add event.
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Tag
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
}
