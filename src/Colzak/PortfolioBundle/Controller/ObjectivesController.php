<?php

// src/Colzak/PortfolioBundle/Controller/ObjectivesController.php

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
use Colzak\PortfolioBundle\Entity\Portfolio;
use Colzak\PortfolioBundle\Entity\Objective;
use Colzak\PortfolioBundle\Entity\Instrument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ObjectivesController extends BaseController
{
    /**
     * GET Route annotation.
     * @Post("/users/{id}/portfolio")
     */
    public function postObjectiveAction($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('ColzakUserBundle:User')->find($id);

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $portfolio = $this->managePortfolio(json_decode($request->getContent(), true));
        }

        $portfolio->setProfile($user->getProfile());
        $em->persist($portfolio);
        $em->flush();

        $data = $portfolio;

        return $this->handleView($this->view($data, 200));
    } // "post_users_portfolios"   [POST] /users/{username}/portfolios

    /**
     * GET Route annotation.
     * @Put("/users/{id}/portfolio/{portfolioId}")
     */
    public function putUserPortfolioAction($id, $portfolioId)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('ColzakUserBundle:User')->find($id);

        $request = $this->getRequest();

        // $portfolio = $em->getRepository('ColzakPortfolioBundle:Portfolio')->find($portfolioId);

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $portfolio = $this->managePortfolio(json_decode($request->getContent(), true));
        }
        $portfolio->setProfile($user->getProfile());
        $em->persist($portfolio);
        $em->flush();
        $data = $portfolio;

        return $this->handleView($this->view($data, 200));

    } // "put_users_portfolio"      [PUT] /users/{id}/portfolio/{portfolioId}

    /**
     * GET Route annotation.
     * @Get("/portfolio/instruments/{slug}")
     */
    public function getPortfolioInstrumentsAction($slug) {
        $em = $this->container->get('doctrine')->getManager();
        $adjective = false;
        if ($this->container->get('request')->query->get('adjective') !== NULL) {
            $adjective = true;
        }
        $data = $em->getRepository('ColzakPortfolioBundle:Instrument')->loadInstrumentsBySlug($slug, $adjective);
        return $this->handleView($this->view($data, 200));
    } // "get_portfolio_instruments"   [GET] /portfolio/instruments/{slug}
}
