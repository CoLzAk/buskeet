<?php
// src/Colzak/GeoBundle/Document/Address.php

namespace Colzak\GeoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 * @SERIAL\ExclusionPolicy("none")
 */
class Address
{
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
     * @MongoDB\EmbedOne(targetDocument="Colzak\GeoBundle\Document\Coordinate")
     * @SERIAL\Type("Colzak\GeoBundle\Document\Coordinate")
     */
    protected $coordinates;

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
     * @param Colzak\GeoBundle\Document\Coordinate $coordinates
     * @return self
     */
    public function setCoordinates(\Colzak\GeoBundle\Document\Coordinate $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return Colzak\GeoBundle\Document\Coordinate $coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
