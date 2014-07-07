<?php
// src/Colzak/PortfolioBundle/Document/PortfolioInstrument.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
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
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $name;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $category;

    public static function getLevelList()
    {
        return array(
            self::LEVEL_BEGINNER => 'Débutant',
            self::LEVEL_AMATEUR => 'Amateur',
            self::LEVEL_PROFESSIONAL => 'Professionnel'
        );
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
     * Set category
     *
     * @param string $category
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
