<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Event;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Edition
 *
 * @ORM\Table(name="edition")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EditionRepository")
 */
class Edition
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull(
     *     message="Ce champs ne peut être vide"
     * )
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull(
     *     message="Ce champs ne peut être vide"
     * )
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="hashtag", type="string", length=255)
     */
    private $hashtag;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="editions")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="edition", cascade={"persist", "remove"})
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="edition", cascade={"persist", "remove"})
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="edition", cascade={"persist", "remove"})
     */
    protected $groups;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Edition
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return Edition
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Edition
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set place.
     *
     * @param string $place
     *
     * @return Edition
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set hashtag.
     *
     * @param string $hashtag
     *
     * @return Edition
     */
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;

        return $this;
    }

    /**
     * Get hashtag.
     *
     * @return string
     */
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Edition
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set event.
     *
     * @param \AppBundle\Entity\Event|null $event
     *
     * @return Edition
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \AppBundle\Entity\Event|null
     */
    public function getEvent()
    {
        return $this->event;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Edition
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        return $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param mixed $tasks
     * @return Edition
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * Add task.
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return Edition
     */
    public function addTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    /**
     * Remove task.
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTask(\AppBundle\Entity\Task $task)
    {
        return $this->tasks->removeElement($task);
    }
  
    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     * @return Edition
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Edition
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add group.
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return Edition
     */
    public function addGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group.
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeGroup(\AppBundle\Entity\Group $group)
    {
        return $this->groups->removeElement($group);
    }
}
