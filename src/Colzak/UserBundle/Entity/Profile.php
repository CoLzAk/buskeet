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
     * @ORM\GeneratedValue(strategy="SEQUENCE")
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
     * @ORM\OneToOne(targetEntity="Colzak\PortfolioBundle\Entity\Portfolio", mappedBy="profile", cascade={"all"})
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Portfolio")
     */
    protected $portfolio;

    /**
     * @ORM\OneToOne(targetEntity="Colzak\UserBundle\Entity\User", inversedBy="profile", cascade={"all"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @SERIAL\Type("Colzak\UserBundle\Entity\User")
     */
    protected $user;

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
}