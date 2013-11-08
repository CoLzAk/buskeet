<?php

// src/Colzak/PortfolioBundle/Controller/PortfoliosController.php

namespace Colzak\PortfolioBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;

class PortfoliosController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{username}/portfolios")
     */
    public function getUserPortfoliosAction($username)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);
        $data = $em->getRepository('ColzakPortfolioBundle:Portfolio')->findAllByProfile($user->getProfile());

        return $this->handleView($this->view($data, 200));
    } // "get_users_portfolios"   [GET] /profiles/{username}/portfolios
}
