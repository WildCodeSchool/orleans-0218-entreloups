<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Edition;
use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
{
    /**
     * @Vich\UploadableField(mapping="event_images", fileNameProperty="imageName")
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/png", "image/jpg"},
     *     mimeTypesMessage = "Wrong file type (jpeg,png,jpg)"
     * )
     * @var File
     *
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updateAt;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"}, inversedBy="events")
     */
    private $tags;

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
     * @ORM\Column(name="code_postal", type="string",length=255 , nullable=true)
     */
    private $codePostal;
  
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     * @JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     *
     * @param File|null $imageFile
     * @return Event
     * @throws \Exception
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     */
    public function setUpdateAt(\DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

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
        $this->editions = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Add edition.
     *
     * @param Edition $edition
     *
     * @return Event
     */
    public function addEdition(Edition $edition)
    {
        $this->editions[] = $edition;

        return $this;
    }

    /**
     * Remove edition.
     *
     * @param Edition $edition
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEdition(Edition $edition)
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

    /**
     * Add tag.
     *
     * @param Tag $tag
     *
     * @return Event
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag.
     *
     * @param Tag $tag
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTag(Tag $tag)
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
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return Event
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
     * @return Event
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;
    }
  
    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Event
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }
  
    /**
     * Set creator.
     *
     * @param \AppBundle\Entity\User|null $creator
     *
     * @return Event
     */
    public function setCreator(\AppBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;
      
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
     * @return Event
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
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
  
    /**
     * Get creator.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getCreator()
    {
        return $this->creator;
    }
}
