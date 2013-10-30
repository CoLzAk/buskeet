<?php

namespace Colzak\GeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ColzakGeoBundle:Default:index.html.twig', array('name' => $name));
    }
}
