<?php

// src/Colzak/FileBundle/Form/Extension/FileTypeExtension.php
namespace Colzak\FileBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;

class FileTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'file';
    }
}