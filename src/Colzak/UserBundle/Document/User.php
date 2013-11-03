<?php
// src/Colzak/UserBundle/Document/User.php

namespace Colzak\UserBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Colzak\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Profile", cascade="all")
     */
    protected $profile;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Portfolio", cascade="all")
     */
    protected $portfolio;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set portfolio
     *
     * @param Colzak\UserBundle\Document\Portfolio $portfolio
     * @return self
     */
    public function setPortfolio(\Colzak\UserBundle\Document\Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    /**
     * Get portfolio
     *
     * @return Colzak\UserBundle\Document\Portfolio $portfolio
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }
}
