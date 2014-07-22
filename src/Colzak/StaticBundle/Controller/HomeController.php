<?php

namespace Colzak\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('ColzakStaticBundle:Home:index.html.twig');
    }

    public function aboutAction() {
    	return $this->render('ColzakStaticBundle:Home:about.html.twig');
    }

    public function cguAction() {
    	return $this->render('ColzakStaticBundle:Home:cgu.html.twig');
    }

    public function privacyAction() {
    	return $this->render('ColzakStaticBundle:Home:privacy.html.twig');
    }
}
