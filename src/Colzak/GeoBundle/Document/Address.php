<?php
// src/Colzak/GeoBundle/Document/Address.php

namespace Colzak\GeoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Address
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $number;

    /**
     * @MongoDB\String
     */
    protected $street;

    /**
     * @MongoDB\String
     */
    protected $complement;

    /**
     * @MongoDB\String
     */
    protected $zipcode;

    /**
     * @MongoDB\String
     */
    protected $city;

    /**
     * @MongoDB\String
     */
    protected $sublocality;

    /**
     * @MongoDB\String
     */
    protected $department;

    /**
     * @MongoDB\String
     */
    protected $region;

    /**
     * @MongoDB\String
     */
    protected $country;

    /**
     * @MongoDB\EmbedOne(targetDocument="Coordinate")
     */
    protected $coordinate;

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
     * Set number
     *
     * @param string $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * Get street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set complement
     *
     * @param string $complement
     * @return self
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * Get complement
     *
     * @return string $complement
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return self
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string $zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
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
     * Set department
     *
     * @param string $department
     * @return self
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * Get department
     *
     * @return string $department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return self
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return string $region
     */
    public function getRegion()
    {
        return $this->region;
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
     * Set coordinate
     *
     * @param Colzak\GeoBundle\Document\Coordinate $coordinate
     * @return self
     */
    public function setCoordinate(\Colzak\GeoBundle\Document\Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
        return $this;
    }

    /**
     * Get coordinate
     *
     * @return Colzak\GeoBundle\Document\Coordinate $coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }
}
