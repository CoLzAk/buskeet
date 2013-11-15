<?php
// src/Colzak/PortfolioBundle/Document/Instrument.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document(repositoryClass="Colzak\PortfolioBundle\Repository\InstrumentRepository")
 * @SERIAL\ExclusionPolicy("none")
 */
class Instrument
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
    protected $name;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\InstrumentType", {"all"})
     * @SERIAL\Type("Colzak\PortfolioBundle\Document\InstrumentType")
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
