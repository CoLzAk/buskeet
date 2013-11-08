<?php
// src/Colzak/PortfolioBundle/Document/Instrument.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document()
 */
class Instrument
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\InstrumentType")
     */
    protected $instrumentType;

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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set instrumentType
     *
     * @param Colzak\PortfolioBundle\Document\InstrumentType $instrumentType
     * @return self
     */
    public function setInstrumentType(\Colzak\PortfolioBundle\Document\InstrumentType $instrumentType)
    {
        $this->instrumentType = $instrumentType;
        return $this;
    }

    /**
     * Get instrumentType
     *
     * @return Colzak\PortfolioBundle\Document\InstrumentType $instrumentType
     */
    public function getInstrumentType()
    {
        return $this->instrumentType;
    }
}
