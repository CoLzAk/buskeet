<?php

namespace Colzak\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('ColzakStaticBundle:Home:index.html.twig');
    }
}
