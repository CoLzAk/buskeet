<?php

namespace Colzak\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends Controller
{
    public function indexAction()
    {
        if (!is_object($this->get('security.context')->getToken()->getUser())) {
            return $this->render('ColzakStaticBundle:Home:index.html.twig');
        }
        return new RedirectResponse($this->container->get('router')->generate('colzak_user_feed'));
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

    public function testAction() {
        return $this->render('ColzakStaticBundle:Home:test.html.twig');
    }
}
