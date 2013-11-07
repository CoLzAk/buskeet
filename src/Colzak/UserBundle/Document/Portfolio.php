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
     * @MongoDB\EmbedMany(targetDocument="Target")
     */
    protected $targets;

    /**
     * @MongoDB\EmbedMany(targetDocument="Objective")
     */
    protected $objectives;

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

    /**
     * Add target
     *
     * @param Colzak\UserBundle\Document\Target $target
     */
    public function addTarget(\Colzak\UserBundle\Document\Target $target)
    {
        $this->targets[] = $target;
    }

    /**
     * Remove target
     *
     * @param Colzak\UserBundle\Document\Target $target
     */
    public function removeTarget(\Colzak\UserBundle\Document\Target $target)
    {
        $this->targets->removeElement($target);
    }

    /**
     * Get targets
     *
     * @return Doctrine\Common\Collections\Collection $targets
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Add objective
     *
     * @param Colzak\UserBundle\Document\Objective $objective
     */
    public function addObjective(\Colzak\UserBundle\Document\Objective $objective)
    {
        $this->objectives[] = $objective;
    }

    /**
     * Remove objective
     *
     * @param Colzak\UserBundle\Document\Objective $objective
     */
    public function removeObjective(\Colzak\UserBundle\Document\Objective $objective)
    {
        $this->objectives->removeElement($objective);
    }

    /**
     * Get objectives
     *
     * @return Doctrine\Common\Collections\Collection $objectives
     */
    public function getObjectives()
    {
        return $this->objectives;
    }
}
