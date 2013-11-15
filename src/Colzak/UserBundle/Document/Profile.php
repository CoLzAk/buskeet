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
     * @SERIAL\Type("integer")
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
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\Portfolio", cascade={"all"})
     * @SERIAL\Type("Colzak\PortfolioBundle\Document\Portfolio")
     */
    protected $portfolio;

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
}
