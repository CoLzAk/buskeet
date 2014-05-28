<?php
// src/Colzak/UserBundle/Document/Profile.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document()
 * @SERIAL\ExclusionPolicy("none")
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
    protected $firstname;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $lastname;

    /**
     * @MongoDB\Date
     * @SERIAL\Type("DateTime")
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
     * @MongoDB\Float
     * @SERIAL\Type("double")
     */
    protected $lat;

    /**
     * @MongoDB\Float
     * @SERIAL\Type("double")
     */
    protected $lon;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\Portfolio", mappedBy="profile")
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

    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lat
     *
     * @param float $lat
     * @return self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Get lat
     *
     * @return float $lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param float $lon
     * @return self
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * Get lon
     *
     * @return float $lon
     */
    public function getLon()
    {
        return $this->lon;
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
}
