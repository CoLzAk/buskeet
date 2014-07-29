<?php

namespace Colzak\CommandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ColzakCommandBundle:Default:index.html.twig', array('name' => $name));
    }
}
