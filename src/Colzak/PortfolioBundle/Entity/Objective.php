<?php
// src/Colzak/PortfolioBundle/Entity/Objective.php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @ORM\Entity
 * @ORM\Table(name="clzk_objective")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class Objective
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $title;

    /**
     * @var string $content
     *
     * @ORM\Column(name="content", type="string", nullable=false)
     * @SERIAL\Type("string")
     */
    protected $content;

    /**
     * @var datetime $startDate
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $startDate;

    /**
     * @var datetime $endTime
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     * @SERIAL\Type("DateTime")
     */
    protected $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="Colzak\PortfolioBundle\Entity\Portfolio", inversedBy="objectives", cascade={"all"})
     * @ORM\JoinColumn(name="portfolio_id", referencedColumnName="id")
     * @SERIAL\Type("Colzak\PortfolioBundle\Entity\Portfolio")
     */
    protected $portfolio;

    /**
     * @ORM\ManyToMany(targetEntity="Colzak\UserBundle\Entity\Profile", inversedBy="objectives")
     * @ORM\JoinTable(name="clzk_objectives_participants")
     * @SERIAL\Type("Colzak\UserBundle\Entity\Profile")
     **/
    protected $participants;

    public function __construct() {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Objective
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Objective
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Objective
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Objective
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set portfolio
     *
     * @param \Colzak\PortfolioBundle\Entity\Portfolio $portfolio
     * @return Objective
     */
    public function setPortfolio(\Colzak\PortfolioBundle\Entity\Portfolio $portfolio = null)
    {
        $this->portfolio = $portfolio;
    
        return $this;
    }

    /**
     * Get portfolio
     *
     * @return \Colzak\PortfolioBundle\Entity\Portfolio 
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }
    
    /**
     * Add participants
     *
     * @param \Colzak\UserBundle\Entity\Profile $participants
     * @return Objective
     */
    public function addParticipant(\Colzak\UserBundle\Entity\Profile $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param \Colzak\UserBundle\Entity\Profile $participants
     */
    public function removeParticipant(\Colzak\UserBundle\Entity\Profile $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}