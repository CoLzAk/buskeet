<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function indexAction($username)
    {
    	$dm = $this->container->get('doctrine_mongodb')->getManager();
    	$targetUser = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }
}
