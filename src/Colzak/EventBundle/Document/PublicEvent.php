<?php
// src/Colzak/EventBundle/Document/Event.php

namespace Colzak\EventBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class PublicEvent
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

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
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $startDate;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $endDate;

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
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\User")
     * @SERIAL\Type("Colzak\UserBundle\Document\User")
     */
    protected $createdBy;

    public function __construct() {
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
     * Set startDate
     *
     * @param date $startDate
     * @return self
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Get startDate
     *
     * @return date $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param date $endDate
     * @return self
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Get endDate
     *
     * @return date $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
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
     * Set createdBy
     *
     * @param Colzak\UserBundle\Document\User $createdBy
     * @return self
     */
    public function setCreatedBy(\Colzak\UserBundle\Document\User $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return Colzak\UserBundle\Document\User $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
