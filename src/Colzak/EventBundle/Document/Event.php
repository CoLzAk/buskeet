<?php
// src/Colzak/EventBundle/Document/Event.php

namespace Colzak\EventBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document(repositoryClass="Colzak\EventBundle\Repository\EventRepository")
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 * @MongoDB\Index(keys={"coordinates"="2d"})
 */
class Event
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="events")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $title;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $content;

    /**
     * @MongoDB\Date
     * @SERIAL\Type("DateTime<'Y-m-d'>")
     */
    protected $date;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $time;

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
     * @MongoDB\EmbedOne(targetDocument="Colzak\EventBundle\Document\Coordinate")
     * @SERIAL\Type("Colzak\EventBundle\Document\Coordinate")
     */
    protected $coordinates;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\UserBundle\Document\Profile")
     * @SERIAL\Type("ArrayCollection<Colzak\UserBundle\Document\Profile>")
     */
    protected $participants = array();

    /** 
     * @MongoDB\Distance 
     * @SERIAL\Type("double")
     */
    public $distance;

    public function __construct() {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set profile
     *
     * @param Colzak\UserBundle\Document\Profile $profile
     * @return self
     */
    public function setProfile(\Colzak\UserBundle\Document\Profile $profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return Colzak\UserBundle\Document\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param date $date
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
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
     * Set coordinates
     *
     * @param Colzak\EventBundle\Document\Coordinate $coordinates
     * @return self
     */
    public function setCoordinates(\Colzak\EventBundle\Document\Coordinate $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return Colzak\EventBundle\Document\Coordinate $coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set time
     *
     * @param date $time
     * @return self
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Get time
     *
     * @return date $time
     */
    public function getTime()
    {
        return $this->time;
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
     * Add participant
     *
     * @param Colzak\UserBundle\Document\Profile $participant
     */
    public function addParticipant(\Colzak\UserBundle\Document\Profile $participant)
    {
        $this->participants[] = $participant;
    }

    /**
     * Remove participant
     *
     * @param Colzak\UserBundle\Document\Profile $participant
     */
    public function removeParticipant(\Colzak\UserBundle\Document\Profile $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return Doctrine\Common\Collections\Collection $participants
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
