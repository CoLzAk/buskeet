<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function indexAction($username)
    {
        // return $this->render('ColzakUserBundle:Profile:index.html.twig', array('username' => $username));
        
        $em = $this->container->get('doctrine')->getManager();

        if ($username == 'me') {
            $targetUser = $this->container->get('security.context')->getToken()->getUser();
        } else {
            $targetUser = $em->getRepository('ColzakUserBundle:User')->loadUserByUsername($username);
        }

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }
}
