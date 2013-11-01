<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Colzak\UserBundle\Document\Portfolio;

class PortfolioController extends Controller
{
    public function newAction()
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();

    	$portfolio = new Portfolio();
    	$portfolioForm = $this->container->get('form.factory')->create(new PortfolioFormType(), $portfolio);

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array('targetUser' => $targetUser));
    }
}
