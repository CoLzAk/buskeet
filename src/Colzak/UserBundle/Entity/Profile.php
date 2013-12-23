<?php
// src/Colzak/UserBundle/Entity/Profile.php

namespace Colzak\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @ORM\Entity
 * @ORM\Table(name="clzk_profile")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class Profile
{
    const GENDER_MALE           = 'MALE';
    const GENDER_FEMALE         = 'FEMALE';

    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @SERIAL\Type("integer")
     */
    protected $id;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $lastname;

    /**
     * @var string $birthdate
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $birthdate;

    /**
     * @var string $gender
     *
     * @ORM\Column(name="gender", type="string", length=8, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $gender;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @SERIAL\Type("string")
     */
    protected $description;

    /**
     * @ORM\OneToOne(targetEntity="Colzak\PortfolioBundle\Entity\Portfolio", mappedBy="profile", cascade={"persist", "remove"})
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Portfolio")
     */
    protected $portfolio;

    /**
     * @ORM\OneToOne(targetEntity="Colzak\UserBundle\Entity\User", mappedBy="profile", cascade={"all"})
     * @SERIAL\Type("Colzak\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @var ArrayCollection $files
     *
     * @ORM\OneToMany(targetEntity="Colzak\FileBundle\Entity\File", mappedBy="profile")
     * @SERIAL\Type("Colzak\FileBundle\Entity\File")
     */
    protected $files;

    /**
     * @ORM\Column(name="street_number", type="string", nullable=true)
     * @SERIAL\Type("string")
     */
    protected $streetNumber;

    /**
     * @ORM\Column(name="route", type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $route;

    /**
     * @ORM\Column(name="locality", type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $locality;

    /**
     * @ORM\Column(name="sublocality", type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $sublocality;

    /**
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $postalCode;

    /**
     * @ORM\Column(name="administrative_area_level_2", type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $administrativeAreaLevel2;

    /**
     * @ORM\Column(name="administrative_area_level_1", type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $administrativeAreaLevel1;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @SERIAL\Type("string")
     */
    protected $country;

    /**
     * @ORM\Column(name="lat", type="float", length=255, nullable=true)
     * @SERIAL\Type("double")
     */
    protected $lat;

    /**
     * @ORM\Column(name="lon", type="float", length=255, nullable=true)
     * @SERIAL\Type("double")
     */
    protected $lon;

    /**
     * @ORM\ManyToMany(targetEntity="Colzak\PortfolioBundle\Entity\Objective", mappedBy="participants")
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Objective")
     **/
    private $objectives;

    public function __construct() {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectives = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set firstname
     *
     * @param string $firstname
     * @return Profile
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Profile
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Profile
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Profile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Profile
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set portfolio
     *
     * @param \Colzak\PortfolioBundle\Entity\Portfolio $portfolio
     * @return Profile
     */
    public function setPortfolio(\Colzak\PortfolioBundle\Entity\Portfolio $portfolio = null)
    {
        $this->portfolio = $portfolio;
    
        return $this;
    }

    /**
     * Get portfolio
     *
     * @return \Colzak\PortfolioBundle\Entity\Portfolio 
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Set user
     *
     * @param \Colzak\UserBundle\Entity\User $user
     * @return Profile
     */
    public function setUser(\Colzak\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Colzak\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Add files
     *
     * @param \Colzak\FileBundle\Entity\File $files
     * @return Profile
     */
    public function addFile(\Colzak\FileBundle\Entity\File $files)
    {
        $this->files[] = $files;
    
        return $this;
    }

    /**
     * Remove files
     *
     * @param \Colzak\FileBundle\Entity\File $files
     */
    public function removeFile(\Colzak\FileBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return Profile
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    
        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string 
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Profile
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Profile
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    
        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set sublocality
     *
     * @param string $sublocality
     * @return Profile
     */
    public function setSublocality($sublocality)
    {
        $this->sublocality = $sublocality;
    
        return $this;
    }

    /**
     * Get sublocality
     *
     * @return string 
     */
    public function getSublocality()
    {
        return $this->sublocality;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Profile
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set administrativeAreaLevel2
     *
     * @param string $administrativeAreaLevel2
     * @return Profile
     */
    public function setAdministrativeAreaLevel2($administrativeAreaLevel2)
    {
        $this->administrativeAreaLevel2 = $administrativeAreaLevel2;
    
        return $this;
    }

    /**
     * Get administrativeAreaLevel2
     *
     * @return string 
     */
    public function getAdministrativeAreaLevel2()
    {
        return $this->administrativeAreaLevel2;
    }

    /**
     * Set administrativeAreaLevel1
     *
     * @param string $administrativeAreaLevel1
     * @return Profile
     */
    public function setAdministrativeAreaLevel1($administrativeAreaLevel1)
    {
        $this->administrativeAreaLevel1 = $administrativeAreaLevel1;
    
        return $this;
    }

    /**
     * Get administrativeAreaLevel1
     *
     * @return string 
     */
    public function getAdministrativeAreaLevel1()
    {
        return $this->administrativeAreaLevel1;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Profile
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
     * Set lat
     *
     * @param float $lat
     * @return Profile
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
     * @return Profile
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

    /**
     * Add objectives
     *
     * @param \Colzak\PortfolioBundle\Entity\Objective $objectives
     * @return Profile
     */
    public function addObjective(\Colzak\PortfolioBundle\Entity\Objective $objectives)
    {
        $this->objectives[] = $objectives;
    
        return $this;
    }

    /**
     * Remove objectives
     *
     * @param \Colzak\PortfolioBundle\Entity\Objective $objectives
     */
    public function removeObjective(\Colzak\PortfolioBundle\Entity\Objective $objectives)
    {
        $this->objectives->removeElement($objectives);
    }

    /**
     * Get objectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjectives()
    {
        return $this->objectives;
    }
}