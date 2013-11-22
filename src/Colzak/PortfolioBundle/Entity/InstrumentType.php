<?php
// src/Colzak/PortfolioBundle/Entity/InstrumentType.php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @ORM\Entity
 * @ORM\Table(name="clzk_instrument_type")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class InstrumentType
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @SERIAL\Type("integer")
     */
    protected $id;

    /**
     * @var string $category
     *
     * @ORM\Column(name="category", type="string", length=50, nullable=false)
     * @SERIAL\Type("string")
     */
    protected $category;

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
     * Set category
     *
     * @param string $category
     * @return InstrumentType
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }
}