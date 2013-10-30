<?php
// src/Colzak/GeoBundle/Document/Coordinate.php

namespace Colzak\GeoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Coordinate
{

    /**
     * @MongoDB\Float
     */
    protected $x;

    /**
     * @MongoDB\Float
     */
    protected $y;

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
}
