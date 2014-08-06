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
    const WOODWINDS = 'woodwinds';
    const BRASS = 'brass';
    const STRINGS = 'strings';
    const PERCUSSIONS = 'percussions';
    const KEYBOARDS = 'keyboards';
    const VOCALS = 'vocals';
    const ELECTRONICS = 'electronics';

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
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $category;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $colorCode;

    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $iconPath;

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

    /**
     * Set colorCode
     *
     * @param string $colorCode
     * @return self
     */
    public function setColorCode($colorCode)
    {
        $this->colorCode = $colorCode;
        return $this;
    }

    /**
     * Get colorCode
     *
     * @return string $colorCode
     */
    public function getColorCode()
    {
        return $this->colorCode;
    }

    /**
     * Set iconPath
     *
     * @param string $iconPath
     * @return self
     */
    public function setIconPath($iconPath)
    {
        $this->iconPath = $iconPath;
        return $this;
    }

    /**
     * Get iconPath
     *
     * @return string $iconPath
     */
    public function getIconPath()
    {
        return $this->iconPath;
    }

    public static function getCategoryList() {
        return array(
            self::WOODWINDS => 'woodwinds',
            self::BRASS => 'brass',
            self::KEYBOARDS => 'keyboards',
            self::STRINGS => 'strings',
            self::VOCALS => 'vocals',
            self::ELECTRONICS => 'electronics',
            self::PERCUSSIONS => 'percussions'
        );
    }
}
