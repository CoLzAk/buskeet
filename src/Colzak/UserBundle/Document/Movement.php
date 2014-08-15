<?php
// src/Colzak/UserBundle/Document/Movement.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document(repositoryClass="Colzak\UserBundle\Repository\MovementRepository")
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Movement
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="movements")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\EmbedOne(targetDocument="Colzak\UserBundle\Document\MovementDetail")
     * @SERIAL\Type("Colzak\UserBundle\Document\MovementDetail")
     */
    protected $movementDetail;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
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
     * Set movementDetail
     *
     * @param Colzak\UserBundle\Document\MovementDetail $movementDetail
     * @return self
     */
    public function setMovementDetail(\Colzak\UserBundle\Document\MovementDetail $movementDetail)
    {
        $this->movementDetail = $movementDetail;
        return $this;
    }

    /**
     * Get movementDetail
     *
     * @return Colzak\UserBundle\Document\MovementDetail $movementDetail
     */
    public function getMovementDetail()
    {
        return $this->movementDetail;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
