<?php
// src/Colzak/MediaBundle/Document/Video.php

namespace Colzak\MediaBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Video
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $title;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $description;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $url;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $plateform;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="videos")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $embeddedCode;

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
     * Set url
     *
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
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
     * Set plateform
     *
     * @param string $plateform
     * @return self
     */
    public function setPlateform($plateform)
    {
        $this->plateform = $plateform;
        return $this;
    }

    /**
     * Get plateform
     *
     * @return string $plateform
     */
    public function getPlateform()
    {
        return $this->plateform;
    }

    /**
     * Set embeddedCode
     *
     * @param string $embeddedCode
     * @return self
     */
    public function setEmbeddedCode($embeddedCode)
    {
        $this->embeddedCode = $embeddedCode;
        return $this;
    }

    /**
     * Get embeddedCode
     *
     * @return string $embeddedCode
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }
}
