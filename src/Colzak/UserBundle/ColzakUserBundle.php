<?php

namespace Colzak\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ColzakUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
