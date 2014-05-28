<?php
// src/Colzak/PortfolioBundle/Document/Portfolio.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\Document
 * @SERIAL\ExclusionPolicy("none")
 * @MongoDB\HasLifecycleCallbacks
 */
class Portfolio
{
    /**
     * @MongoDB\Id(strategy="auto")
     * @SERIAL\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Colzak\UserBundle\Document\Profile", inversedBy="portfolio")
     * @SERIAL\Type("Colzak\UserBundle\Document\Profile")
     */
    protected $profile;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Colzak\PortfolioBundle\Document\PortfolioInstrument", mappedBy="portfolio", cascade={"all"})
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
     * Set profile
     *
     * @param Colzak\UserBundle\Document\Profile $profile
     * @return self
     */
    public function setProfile(\Colzak\UserBundle\Document\Profile $profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return Colzak\UserBundle\Document\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
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
