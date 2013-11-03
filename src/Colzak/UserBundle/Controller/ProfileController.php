<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function indexAction($username)
    {
		return $this->render('ColzakUserBundle:Profile:index.html.twig', array('username' => $username));
    	
    	// $dm = $this->container->get('doctrine_mongodb')->getManager();

    	// if ($username == 'me') {
    	// 	$targetUser = $this->container->get('security.context')->getToken()->getUser();
    	// } else {
    	// 	$targetUser = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);
    	// }

     //    return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }
}
