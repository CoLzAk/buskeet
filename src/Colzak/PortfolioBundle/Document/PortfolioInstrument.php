<?php
// src/Colzak/PortfolioBundle/Document/PortfolioInstrument.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class PortfolioInstrument
{
    const LEVEL_BEGINNER = 'BEGINNER';
    const LEVEL_AMATEUR = 'AMATEUR';
    const LEVEL_PROFESSIONAL = 'PROFESSIONAL';

    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $level;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\Portfolio", inversedBy="portfolioInstruments")
     * @SERIAL\Type("Colzak\PortfolioBundle\Document\Portfolio")
     */
    protected $portfolio;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\PortfolioBundle\Document\Instrument")
     * @SERIAL\Type("Colzak\PortfolioBundle\Document\Instrument")
     */
    protected $instrument;

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
     * Set level
     *
     * @param string $level
     * @return self
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return string $level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set portfolio
     *
     * @param Colzak\PortfolioBundle\Document\Portfolio $portfolio
     * @return self
     */
    public function setPortfolio(\Colzak\PortfolioBundle\Document\Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    /**
     * Get portfolio
     *
     * @return Colzak\PortfolioBundle\Document\Portfolio $portfolio
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Set instrument
     *
     * @param Colzak\PortfolioBundle\Document\Instrument $instrument
     * @return self
     */
    public function setInstrument(\Colzak\PortfolioBundle\Document\Instrument $instrument)
    {
        $this->instrument = $instrument;
        return $this;
    }

    /**
     * Get instrument
     *
     * @return Colzak\PortfolioBundle\Document\Instrument $instrument
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    public static function getLevelList()
    {
        return array(
            self::LEVEL_BEGINNER => 'Débutant',
            self::LEVEL_AMATEUR => 'Amateur',
            self::LEVEL_PROFESSIONAL => 'Professionnel'
        );
    }
}
