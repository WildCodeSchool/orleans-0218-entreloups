<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publicationTime", type="datetime")
     */
    private $publicationTime;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Edition", inversedBy="notifications")
     * @ORM\JoinColumn(name="edition_id", referencedColumnName="id")
     */
    private $edition;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->publicationTime = new \DateTime('now');
    }


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
     * Set content.
     *
     * @param string $content
     *
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publicationTime.
     *
     * @param \DateTime $publicationTime
     *
     * @return Notification
     */
    public function setPublicationTime($publicationTime)
    {
        $this->publicationTime = $publicationTime;

        return $this;
    }

    /**
     * Get publicationTime.
     *
     * @return \DateTime
     */
    public function getPublicationTime()
    {
        return $this->publicationTime;
    }

    /**
     * Set edition.
     *
     * @param \AppBundle\Entity\Edition|null $edition
     *
     * @return Notification
     */
    public function setEdition(\AppBundle\Entity\Edition $edition = null)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition.
     *
     * @return \AppBundle\Entity\Edition|null
     */
    public function getEdition()
    {
        return $this->edition;
    }
}
