<?php

namespace Colzak\GeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clzk_place")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Colzak\GeoBundle\Entity\PlaceRepository")
 */

class Place {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="city", type="string", length=128, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(name="county", type="string", length=128, nullable=true)
     */
    protected $county;

    /**
     * @ORM\Column(name="postcode", type="string", length=10, nullable=true)
     */
    protected $postcode;

    /**
     * @ORM\Column(name="state", type="string", length=128, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(name="country", type="string", length=128, nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(name="country_code", type="string", length=128, nullable=true)
     */
    protected $countryCode;

    /**
     * @ORM\Column(name="lat", type="float", length=255, nullable=true)
     */
    protected $lat;

    /**
     * @ORM\Column(name="lon", type="float", length=255, nullable=true)
     */
    protected $lon;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Place
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
     * Set county
     *
     * @param string $county
     * @return Place
     */
    public function setCounty($county)
    {
        $this->county = $county;
    
        return $this;
    }

    /**
     * Get county
     *
     * @return string 
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Place
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    
        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Place
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Place
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return Place
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    
        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Place
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param float $lon
     * @return Place
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    
        return $this;
    }

    /**
     * Get lon
     *
     * @return float 
     */
    public function getLon()
    {
        return $this->lon;
    }
}