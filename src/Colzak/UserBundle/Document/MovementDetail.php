<?php
// src/Colzak/UserBundle/Document/MovementDetail.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 * @SERIAL\ExclusionPolicy("none")
 */
class MovementDetail
{
	const ACTION_ADDED_PHOTO 			= 'ADDED_PHOTO';
	const ACTION_CHANGED_PROFILE_PHOTO 	= 'CHANGED_PROFILE_PHOTO';
	const ACTION_ADDED_EVENT			= 'ADDED_EVENT';
	const ACTION_PARTICIPATE_EVENT		= 'PARTICIPATE_EVENT';
	const ACTION_FOLLOWED_USER			= 'FOLLOWED_USER';

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $action;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\MediaBundle\Document\Photo")
     * @SERIAL\Type("Colzak\MediaBundle\Document\Photo")
     */
    protected $photo;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\EventBundle\Document\Event")
     * @SERIAL\Type("Colzak\EventBundle\Document\Event")
     */
    protected $event;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;


    /**
     * Set action
     *
     * @param string $action
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Get action
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set photo
     *
     * @param Colzak\MediaBundle\Document\Photo $photo
     * @return self
     */
    public function setPhoto(\Colzak\MediaBundle\Document\Photo $photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Get photo
     *
     * @return Colzak\MediaBundle\Document\Photo $photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set event
     *
     * @param Colzak\EventBundle\Document\Event $event
     * @return self
     */
    public function setEvent(\Colzak\EventBundle\Document\Event $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Get event
     *
     * @return Colzak\EventBundle\Document\Event $event
     */
    public function getEvent()
    {
        return $this->event;
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
