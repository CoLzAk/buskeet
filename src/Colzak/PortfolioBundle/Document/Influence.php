<?php
// src/Colzak/PortfolioBundle/Document/Influence.php

namespace Colzak\PortfolioBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as SERIAL;

/**
 * @MongoDB\EmbeddedDocument
 */
class Influence
{
    /**
     * @MongoDB\String
     * @SERIAL\Type("string")
     */
    protected $name;

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
}
