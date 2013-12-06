<?php

namespace Colzak\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($category, $localization, Request $request)
    {
        return $this->render('ColzakSearchBundle:Default:index.html.twig');
    }

    //Ajax called from beginning to paginate and render partial result (just the user div)
    public function getResultsAction() {
        $em = $this->container->get('doctrine')->getManager();
        $users = $em->getRepository('ColzakUserBundle:User')->findAll();
        return $this->render('ColzakSearchBundle:Default:partials/result.html.twig', array('users' => $users));
    }
}
