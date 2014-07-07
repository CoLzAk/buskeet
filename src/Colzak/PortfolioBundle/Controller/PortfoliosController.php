<?php

// src/Colzak/PortfolioBundle/Controller/PortfoliosController.php

namespace Colzak\PortfolioBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;
use Colzak\PortfolioBundle\Document\Portfolio;
use Colzak\PortfolioBundle\Document\PortfolioInstrument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PortfoliosController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{userId}/portfolio")
     */
    public function getUserPortfolioAction($userId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $data = $dm->getRepository('ColzakPortfolioBundle:Portfolio')->findByProfile($user->getProfile());

        return $this->handleView($this->view($data, 200));
    } // "get_users_portfolio"   [GET] /users/{userId}/portfolio

    /**
     * GET Route annotation.
     * @Put("/users/{userId}/portfolio/{portfolioId}")
     */
    public function putUserPortfolioAction($userId, $portfolioId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $portfolio = $dm->getRepository('ColzakPortfolioBundle:Portfolio')->find($portfolioId);

        $request = $this->getRequest();

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $updatedPortfolio = $serializer->deserialize($request->getContent(), 'Colzak\PortfolioBundle\Document\Portfolio', 'json');
        }

        $updatedPortfolio->setProfile($user->getProfile());
        $portfolio = $dm->merge($updatedPortfolio);
        $dm->flush();
        $data = $updatedPortfolio;

        return $this->handleView($this->view($data, 200));
    } // "put_users_portfolio"      [PUT] /users/{id}/portfolio/{portfolioId}
}
