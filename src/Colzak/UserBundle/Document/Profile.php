<?php
// src/Colzak/UserBundle/Document/Profile.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;
use Colzak\PortfolioBundle\Document\Portfolio;

/**
 * @MongoDB\Document(repositoryClass="Colzak\UserBundle\Repository\ProfileRepository")
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 * @MongoDB\Index(keys={"coordinates"="2d"})
 */
class Profile
{
    const GENDER_MALE           = 'MALE';
    const GENDER_FEMALE         = 'FEMALE';

    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $username;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $firstname;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $lastname;

    /**
     * @MongoDB\Date
     * @SERIAL\Type("DateTime<'Y-m-d'>")
     */
    protected $birthdate;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $gender;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $description;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $streetNumber;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $route;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $locality;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $sublocality;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $postalCode;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $administrativeAreaLevel2;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $administrativeAreaLevel1;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $country;

    /**
     * @MongoDB\EmbedOne(targetDocument="Colzak\UserBundle\Document\Coordinate")
     * @SERIAL\Type("Colzak\UserBundle\Document\Coordinate")
     */
    protected $coordinates;

    /**
     * @MongoDB\EmbedOne(targetDocument="Colzak\PortfolioBundle\Document\Portfolio")
     * @SERIAL\Type("Colzak\PortfolioBundle\Document\Portfolio")
     */
    protected $portfolio;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\MediaBundle\Document\Photo", mappedBy="profile")
     * @SERIAL\Type("ArrayCollection<Colzak\MediaBundle\Document\Photo>")
     */
    protected $photos = array();

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\EventBundle\Document\Event", mappedBy="profile")
     * @SERIAL\Type("ArrayCollection<Colzak\EventBundle\Document\Event>")
     */
    protected $events = array();

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $updatedAt;

    /** 
     * @MongoDB\Distance 
     * @SERIAL\Type("double")
     */
    public $distance;

    /**
     * @MongoDB\Boolean
     * @SERIAL\Type("boolean")
     */
    protected $enabled = TRUE;

    public function __construct()
    {
        $this->portfolio = new Portfolio();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @MongoDB\PreUpdate()
     */
    public function preUpdate() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param date $birthdate
     * @return self
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return date $birthdate
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Get gender
     *
     * @return string $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return self
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string $streetNumber
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return self
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Get route
     *
     * @return string $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return self
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
        return $this;
    }

    /**
     * Get locality
     *
     * @return string $locality
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set sublocality
     *
     * @param string $sublocality
     * @return self
     */
    public function setSublocality($sublocality)
    {
        $this->sublocality = $sublocality;
        return $this;
    }

    /**
     * Get sublocality
     *
     * @return string $sublocality
     */
    public function getSublocality()
    {
        return $this->sublocality;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return self
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string $postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set administrativeAreaLevel2
     *
     * @param string $administrativeAreaLevel2
     * @return self
     */
    public function setAdministrativeAreaLevel2($administrativeAreaLevel2)
    {
        $this->administrativeAreaLevel2 = $administrativeAreaLevel2;
        return $this;
    }

    /**
     * Get administrativeAreaLevel2
     *
     * @return string $administrativeAreaLevel2
     */
    public function getAdministrativeAreaLevel2()
    {
        return $this->administrativeAreaLevel2;
    }

    /**
     * Set administrativeAreaLevel1
     *
     * @param string $administrativeAreaLevel1
     * @return self
     */
    public function setAdministrativeAreaLevel1($administrativeAreaLevel1)
    {
        $this->administrativeAreaLevel1 = $administrativeAreaLevel1;
        return $this;
    }

    /**
     * Get administrativeAreaLevel1
     *
     * @return string $administrativeAreaLevel1
     */
    public function getAdministrativeAreaLevel1()
    {
        return $this->administrativeAreaLevel1;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Set portfolio
     *
     * @param Colzak\PortfolioBundle\Document\Portfolio $portfolio
     * @return self
     */
    public function setPortfolio(\Colzak\PortfolioBundle\Document\Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    /**
     * Get portfolio
     *
     * @return Colzak\PortfolioBundle\Document\Portfolio $portfolio
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Add photo
     *
     * @param Colzak\MediaBundle\Document\Photo $photo
     */
    public function addPhoto(\Colzak\MediaBundle\Document\Photo $photo)
    {
        $this->photos[] = $photo;
    }

    /**
     * Remove photo
     *
     * @param Colzak\MediaBundle\Document\Photo $photo
     */
    public function removePhoto(\Colzak\MediaBundle\Document\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\Collection $photos
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add event
     *
     * @param Colzak\EventBundle\Document\Event $event
     */
    public function addEvent(\Colzak\EventBundle\Document\Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * Remove event
     *
     * @param Colzak\EventBundle\Document\Event $event
     */
    public function removeEvent(\Colzak\EventBundle\Document\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return Doctrine\Common\Collections\Collection $events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set coordinates
     *
     * @param Colzak\UserBundle\Document\Coordinate $coordinates
     * @return self
     */
    public function setCoordinates(\Colzak\UserBundle\Document\Coordinate $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return Colzak\UserBundle\Document\Coordinate $coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set distance
     *
     * @param string $distance
     * @return self
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Get distance
     *
     * @return string $distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean $deleted
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set blacklisted
     *
     * @param boolean $blacklisted
     * @return self
     */
    public function setBlacklisted($blacklisted)
    {
        $this->blacklisted = $blacklisted;
        return $this;
    }

    /**
     * Get blacklisted
     *
     * @return boolean $blacklisted
     */
    public function getBlacklisted()
    {
        return $this->blacklisted;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return self
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}
