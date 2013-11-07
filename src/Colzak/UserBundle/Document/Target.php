<?php
// src/Colzak/UserBundle/Document/Coordinate.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Target
{

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\MusicBundle\Document\Instrument")
     */
    protected $instruments;
    
    public function __construct()
    {
        $this->instruments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add instrument
     *
     * @param Colzak\MusicBundle\Document\Instrument $instrument
     */
    public function addInstrument(\Colzak\MusicBundle\Document\Instrument $instrument)
    {
        $this->instruments[] = $instrument;
    }

    /**
     * Remove instrument
     *
     * @param Colzak\MusicBundle\Document\Instrument $instrument
     */
    public function removeInstrument(\Colzak\MusicBundle\Document\Instrument $instrument)
    {
        $this->instruments->removeElement($instrument);
    }

    /**
     * Get instruments
     *
     * @return Doctrine\Common\Collections\Collection $instruments
     */
    public function getInstruments()
    {
        return $this->instruments;
    }
}
