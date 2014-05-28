<?php
// src/Colzak/EventBundle/Document/Event.php

namespace Colzak\EventBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Event
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="events")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $title;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $content;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $startDate;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $endDate;

    public function __construct() {
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
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set startDate
     *
     * @param date $startDate
     * @return self
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Get startDate
     *
     * @return date $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param date $endDate
     * @return self
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Get endDate
     *
     * @return date $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
