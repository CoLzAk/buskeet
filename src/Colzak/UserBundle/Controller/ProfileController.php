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

        // if ($targetUser === $visitor) {
        //     if (count($em->getRepository('ColzakPortfolioBundle:Portfolio')->findByProfile($targetUser->getProfile())) === 0) {
        //         var_dump('test');
        //         $portfolio = new Portfolio();
        //         $portfolio->setProfile($targetUser->getProfile());
                
        //         $em->persist($portfolio);
        //         $em->flush();
        //     }
        // }

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }
}
