<?php
// src/Colzak/UserBundle/Document/Portfolio.php

namespace Colzak\UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document()
 */
class Portfolio
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\MusicBundle\Document\Instrument")
     */
    protected $instruments;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->instruments = new \Doctrine\Common\Collections\ArrayCollection();
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
