<?php
// src/Colzak/PortfolioBundle/Entity/Instrument.php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Colzak\PortfolioBundle\Entity\InstrumentRepository")
 * @ORM\Table(name="clzk_instrument")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class Instrument
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @SERIAL\Type("integer")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Colzak\PortfolioBundle\Entity\InstrumentType")
     * @ORM\JoinColumn(name="instrument_type_id", referencedColumnName="id")
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\InstrumentType")
     */
    protected $instrumentType;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set instrumentType
     *
     * @param \Colzak\PortfolioBundle\Entity\InstrumentType $instrumentType
     * @return Instrument
     */
    public function setInstrumentType(\Colzak\PortfolioBundle\Entity\InstrumentType $instrumentType = null)
    {
        $this->instrumentType = $instrumentType;
    
        return $this;
    }

    /**
     * Get instrumentType
     *
     * @return \Colzak\PortfolioBundle\Entity\InstrumentType 
     */
    public function getInstrumentType()
    {
        return $this->instrumentType;
    }
}