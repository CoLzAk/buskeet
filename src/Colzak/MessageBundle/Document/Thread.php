<?php
// src/Colzak/MessageBundle/Document/Message.php

namespace Colzak\MessageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document(repositoryClass="Colzak\MessageBundle\Repository\ThreadRepository")
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Thread
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @MongoDB\Date(nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $updatedAt;

    /**
     * @MongoDB\EmbedMany(targetDocument="Colzak\MessageBundle\Document\Message")
     * @SERIAL\Type("ArrayCollection<Colzak\MessageBundle\Document\Message>")
     */
    protected $messages = array();

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\UserBundle\Document\Profile")
     * @SERIAL\Type("ArrayCollection<Colzak\UserBundle\Document\Profile>")
     */
    protected $participants = array();

    public function __construct() {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @MongoDB\PrePersist()
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @MongoDB\PreUpdate()
     */
    public function preUpdate() {
        $this->updatedAt = new \DateTime();
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

    /**
     * Set updatedAt
     *
     * @param date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add message
     *
     * @param Colzak\MessageBundle\Document\Message $message
     */
    public function addMessage(\Colzak\MessageBundle\Document\Message $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Remove message
     *
     * @param Colzak\MessageBundle\Document\Message $message
     */
    public function removeMessage(\Colzak\MessageBundle\Document\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return Doctrine\Common\Collections\Collection $messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add participant
     *
     * @param Colzak\UserBundle\Document\Profile $participant
     */
    public function addParticipant(\Colzak\UserBundle\Document\Profile $participant)
    {
        $this->participants[] = $participant;
    }

    /**
     * Remove participant
     *
     * @param Colzak\UserBundle\Document\Profile $participant
     */
    public function removeParticipant(\Colzak\UserBundle\Document\Profile $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return Doctrine\Common\Collections\Collection $participants
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
