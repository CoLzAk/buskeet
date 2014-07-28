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
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Profile", cascade="all")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

        /**
     * @MongoDB\Boolean
     * @SERIAL\Type("boolean")
     */
    protected $deleted = FALSE;

    /**
     * @MongoDB\Boolean
     * @SERIAL\Type("boolean")
     */
    protected $blacklisted = FALSE;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $deletedAt;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $facebookId;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $facebookAccessToken;

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
     * Set deleted
     *
     * @param boolean $deleted
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean $deleted
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set blacklisted
     *
     * @param boolean $blacklisted
     * @return self
     */
    public function setBlacklisted($blacklisted)
    {
        $this->blacklisted = $blacklisted;
        return $this;
    }

    /**
     * Get blacklisted
     *
     * @return boolean $blacklisted
     */
    public function getBlacklisted()
    {
        return $this->blacklisted;
    }

    /**
     * Set deletedAt
     *
     * @param date $deletedAt
     * @return self
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return date $deletedAt
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return self
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string $facebookId
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return self
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;
        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string $facebookAccessToken
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }
}
