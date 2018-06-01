<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotNull(
     *     message="Ce champs ne peut être vide"
     * )
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="Le titre est trop long !"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotNull(
     *     message="Ce champs ne peut être vide")
     * @Assert\Length(
     *     max = 255 )
     *
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\NotNull(
     *     message = "Ce champs ne peut être vide")
     * @Assert\Length(
     *     max = 255 )
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=2000)
     * @Assert\NotNull(
     *     message="Ce champs ne peut être vide")
     * @Assert\Length(
     *     max = 2000,
     *     maxMessage="La description est trop longue !"
     * )
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Edition", mappedBy="event")
     */
    private $editions;


    public function __toString()
    {
        return $this->getTitle();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->editions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add edition.
     *
     * @param \AppBundle\Entity\Edition $edition
     *
     * @return Event
     */
    public function addEdition(\AppBundle\Entity\Edition $edition)
    {
        $this->editions[] = $edition;

        return $this;
    }

    /**
     * Remove edition.
     *
     * @param \AppBundle\Entity\Edition $edition
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEdition(\AppBundle\Entity\Edition $edition)
    {
        return $this->editions->removeElement($edition);
    }

    /**
     * Get editions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEditions()
    {
        return $this->editions;
    }
}
