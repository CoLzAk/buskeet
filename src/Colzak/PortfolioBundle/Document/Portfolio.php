<?php
// src/Colzak/PortfolioBundle/Document/Portfolio.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 */
class Portfolio
{
    /**
     * @MongoDB\EmbedMany(targetDocument="Colzak\PortfolioBundle\Document\PortfolioInstrument")
     * @SERIAL\Type("ArrayCollection<Colzak\PortfolioBundle\Document\PortfolioInstrument>")
     */
    protected $portfolioInstruments = array();

    /**
     * @MongoDB\EmbedMany(targetDocument="Colzak\PortfolioBundle\Document\MusicStyle")
     * @SERIAL\Type("ArrayCollection<Colzak\PortfolioBundle\Document\MusicStyle>")
     */
    protected $musicStyles = array();

    /**
     * @MongoDB\EmbedMany(targetDocument="Colzak\PortfolioBundle\Document\Influence")
     * @SERIAL\Type("ArrayCollection<Colzak\PortfolioBundle\Document\Influence>")
     */
    protected $influences = array();



    public function __construct() {
        $this->portfolioInstruments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->musicStyles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->influences = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add portfolioInstrument
     *
     * @param Colzak\PortfolioBundle\Document\PortfolioInstrument $portfolioInstrument
     */
    public function addPortfolioInstrument(\Colzak\PortfolioBundle\Document\PortfolioInstrument $portfolioInstrument)
    {
        $this->portfolioInstruments[] = $portfolioInstrument;
    }

    /**
     * Remove portfolioInstrument
     *
     * @param Colzak\PortfolioBundle\Document\PortfolioInstrument $portfolioInstrument
     */
    public function removePortfolioInstrument(\Colzak\PortfolioBundle\Document\PortfolioInstrument $portfolioInstrument)
    {
        $this->portfolioInstruments->removeElement($portfolioInstrument);
    }

    /**
     * Get portfolioInstruments
     *
     * @return Doctrine\Common\Collections\Collection $portfolioInstruments
     */
    public function getPortfolioInstruments()
    {
        return $this->portfolioInstruments;
    }

    /**
     * Add musicStyle
     *
     * @param Colzak\PortfolioBundle\Document\MusicStyle $musicStyle
     */
    public function addMusicStyle(\Colzak\PortfolioBundle\Document\MusicStyle $musicStyle)
    {
        $this->musicStyles[] = $musicStyle;
    }

    /**
     * Remove musicStyle
     *
     * @param Colzak\PortfolioBundle\Document\MusicStyle $musicStyle
     */
    public function removeMusicStyle(\Colzak\PortfolioBundle\Document\MusicStyle $musicStyle)
    {
        $this->musicStyles->removeElement($musicStyle);
    }

    /**
     * Get musicStyles
     *
     * @return Doctrine\Common\Collections\Collection $musicStyles
     */
    public function getMusicStyles()
    {
        return $this->musicStyles;
    }

    /**
     * Add influence
     *
     * @param Colzak\PortfolioBundle\Document\Influence $influence
     */
    public function addInfluence(\Colzak\PortfolioBundle\Document\Influence $influence)
    {
        $this->influences[] = $influence;
    }

    /**
     * Remove influence
     *
     * @param Colzak\PortfolioBundle\Document\Influence $influence
     */
    public function removeInfluence(\Colzak\PortfolioBundle\Document\Influence $influence)
    {
        $this->influences->removeElement($influence);
    }

    /**
     * Get influences
     *
     * @return Doctrine\Common\Collections\Collection $influences
     */
    public function getInfluences()
    {
        return $this->influences;
    }
}
