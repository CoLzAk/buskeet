<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Colzak\PortfolioBundle\Entity\Portfolio;

class ProfileController extends Controller
{
    public function indexAction($username)
    {
        $em = $this->container->get('doctrine')->getManager();
        $visitor = $this->container->get('security.context')->getToken()->getUser();

        if ($username == 'me') {
            $targetUser = $visitor;
        } else {
            $targetUser = $em->getRepository('ColzakUserBundle:User')->loadUserByUsername($username);
        }

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }

    public function getLastSubscribedUser() {
        $em = $this->container->get('doctrine')->getManager();
        $users = $em->getRepository('ColzakUserBundle:User')->getLastUsers();
        return $this->render('ColzakUserBundle:Profile:partials/last_users.html.twig', array('users' => $users));
    }
}
