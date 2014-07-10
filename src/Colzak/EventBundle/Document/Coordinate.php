<?php
// src/Colzak/EventBundle/Document/Coordinate.php

namespace Colzak\EventBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 * @SERIAL\ExclusionPolicy("none")
 */
class Coordinate
{
    /**
     * @MongoDB\Float
     * @SERIAL\Type("double")
     */
    protected $y;

    /**
     * @MongoDB\Float
     * @SERIAL\Type("double")
     */
    protected $x;

    /**
     * Set y
     *
     * @param float $y
     * @return self
     */
    public function setY($y)
    {
        $this->y = $y;
        return $this;
    }

    /**
     * Get y
     *
     * @return float $y
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set x
     *
     * @param float $x
     * @return self
     */
    public function setX($x)
    {
        $this->x = $x;
        return $this;
    }

    /**
     * Get x
     *
     * @return float $x
     */
    public function getX()
    {
        return $this->x;
    }
}
