<?php
// src/Colzak/UserBundle/Document/User.php

namespace Colzak\UserBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document(repositoryClass="Colzak\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("integer")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Profile", cascade="all")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

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
}
