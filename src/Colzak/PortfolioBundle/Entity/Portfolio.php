<?php
// src/Colzak/PortfolioBundle/Entity/Portfolio.php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Colzak\PortfolioBundle\Entity\PortfolioRepository")
 * @ORM\Table(name="clzk_portfolio")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class Portfolio
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
     * @var ArrayCollection $instruments
     *
     * @ORM\ManyToMany(targetEntity="Colzak\PortfolioBundle\Entity\Instrument")
     * @ORM\JoinTable(name="clzk_portfolios_instuments",
     *      joinColumns={@ORM\JoinColumn(name="portfolio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")}
     *      )
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Instrument")
     */
    protected $instruments;

    /**
     * @var string $targetsDescription
     *
     * @ORM\Column(name="targetsDescription", type="string", nullable=false)
     * @SERIAL\Type("string")
     */
    protected $targetsDescription;

    /**
     * @var ArrayCollection $targets
     *
     * @ORM\ManyToMany(targetEntity="Colzak\PortfolioBundle\Entity\Instrument")
     * @ORM\JoinTable(name="clzk_portfolios_targets",
     *      joinColumns={@ORM\JoinColumn(name="portfolio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")}
     *      )
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Instrument")
     */
    protected $targets;

    /**
     * @var ArrayCollection $objectives
     *
     * @ORM\ManyToMany(targetEntity="Colzak\PortfolioBundle\Entity\Objective")
     * @ORM\JoinTable(name="clzk_portfolios_objectives",
     *      joinColumns={@ORM\JoinColumn(name="portfolio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="objective_id", referencedColumnName="id")}
     *      )
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Objective")
     */
    protected $objectives;

    /**
     * @ORM\OneToOne(targetEntity="Colzak\UserBundle\Entity\Profile", inversedBy="portfolio", cascade={"all"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")
     * @SERIAL\Type("Colzak\UserBundle\Entity\Profile")
     */
    protected $profile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instruments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->targets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectives = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set targetsDescription
     *
     * @param string $targetsDescription
     * @return Portfolio
     */
    public function setTargetsDescription($targetsDescription)
    {
        $this->targetsDescription = $targetsDescription;
    
        return $this;
    }

    /**
     * Get targetsDescription
     *
     * @return string 
     */
    public function getTargetsDescription()
    {
        return $this->targetsDescription;
    }

    /**
     * Add instruments
     *
     * @param \Colzak\PortfolioBundle\Entity\Instrument $instrument
     * @return Portfolio
     */
    public function addInstrument(\Colzak\PortfolioBundle\Entity\Instrument $instrument)
    {
        if ($this->instruments->contains($instrument)) {
            $this->instruments[] = $instrument;
        }
    
        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \Colzak\PortfolioBundle\Entity\Instrument $instrument
     */
    public function removeInstrument(\Colzak\PortfolioBundle\Entity\Instrument $instrument)
    {
        $this->instruments->removeElement($instrument);
    }

    /**
     * Get instruments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * Add targets
     *
     * @param \Colzak\PortfolioBundle\Entity\Instrument $target
     * @return Portfolio
     */
    public function addTarget(\Colzak\PortfolioBundle\Entity\Instrument $target)
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
        }
        return $this;
    }

    /**
     * Remove targets
     *
     * @param \Colzak\PortfolioBundle\Entity\Instrument $target
     */
    public function removeTarget(\Colzak\PortfolioBundle\Entity\Instrument $target)
    {
        $this->targets->removeElement($target);
    }

    /**
     * Get targets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Add objectives
     *
     * @param \Colzak\PortfolioBundle\Entity\Objective $objective
     * @return Portfolio
     */
    public function addObjective(\Colzak\PortfolioBundle\Entity\Objective $objective)
    {
        if ($this->objectives->contains($objective)) {
            $this->objectives[] = $objective;
        }
    
        return $this;
    }

    /**
     * Remove objectives
     *
     * @param \Colzak\PortfolioBundle\Entity\Objective $objective
     */
    public function removeObjective(\Colzak\PortfolioBundle\Entity\Objective $objective)
    {
        $this->objectives->removeElement($objective);
    }

    /**
     * Get objectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjectives()
    {
        return $this->objectives;
    }

    /**
     * Set profile
     *
     * @param \Colzak\UserBundle\Entity\Profile $profile
     * @return Portfolio
     */
    public function setProfile(\Colzak\UserBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return \Colzak\UserBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
}