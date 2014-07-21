<?php
// src/Colzak/MessageBundle/Document/Message.php

namespace Colzak\MessageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Message
{
    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $sender;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $recipient;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $message;

    /**
     * @MongoDB\Boolean
     * @SERIAL\Type("boolean")
     */
    protected $isReadByRecipient = FALSE;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $sendAt;

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist() {
        $this->sendAt = new \DateTime();
    }

    /**
     * Set sender
     *
     * @param Colzak\UserBundle\Document\Profile $sender
     * @return self
     */
    public function setSender(\Colzak\UserBundle\Document\Profile $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Get sender
     *
     * @return Colzak\UserBundle\Document\Profile $sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set recipient
     *
     * @param Colzak\UserBundle\Document\Profile $recipient
     * @return self
     */
    public function setRecipient(\Colzak\UserBundle\Document\Profile $recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * Get recipient
     *
     * @return Colzak\UserBundle\Document\Profile $recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isReadByRecipient
     *
     * @param boolean $isReadByRecipient
     * @return self
     */
    public function setIsReadByRecipient($isReadByRecipient)
    {
        $this->isReadByRecipient = $isReadByRecipient;
        return $this;
    }

    /**
     * Get isReadByRecipient
     *
     * @return boolean $isReadByRecipient
     */
    public function getIsReadByRecipient()
    {
        return $this->isReadByRecipient;
    }

    /**
     * Set sendAt
     *
     * @param date $sendAt
     * @return self
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;
        return $this;
    }

    /**
     * Get sendAt
     *
     * @return date $sendAt
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }
}
