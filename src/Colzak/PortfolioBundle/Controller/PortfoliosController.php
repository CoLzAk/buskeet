<?php

// src/Colzak/PortfolioBundle/Controller/PortfoliosController.php

namespace Colzak\PortfolioBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;
use Colzak\PortfolioBundle\Document\Portfolio;
use Symfony\Component\HttpFoundation\Response;

class PortfoliosController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{id}/portfolio")
     */
    public function getUserPortfolioAction($id)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);
        $data = $em->getRepository('ColzakPortfolioBundle:Portfolio')->findAllByProfile($user->getProfile());

        return $this->handleView($this->view($data, 200));
    } // "get_users_portfolio"   [GET] /users/{id}/portfolio

    /**
     * GET Route annotation.
     * @Post("/users/{id}/portfolio")
     */
    public function postUserPortfolioAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $dm = $this->container->get('doctrine_mongodb')->getManager();

        $portfolio = new Portfolio();

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $portfolio = $serializer->deserialize($request->getContent(), 'Colzak\PortfolioBundle\Document\Portfolio', 'json');
        }

        $dm->persist($portfolio);

        $user->getProfile()->setPortfolio($portfolio);

        $dm->flush();

        $data = $portfolio;

        return $this->handleView($this->view($data, 200));
    } // "post_users_portfolios"   [POST] /users/{username}/portfolios

    /**
     * GET Route annotation.
     * @Get("/portfolio/instruments/{slug}")
     */
    public function getPortfolioInstrumentsAction($slug) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        // $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findInstrumentsBySlug($slug)->toArray();
        $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findAll()->toArray();

        // $serializer = $this->get('jms_serializer');
        // $response = new Response(json_encode(array('data' => $data)));
        // $response->headers->set('Content-Type', 'application/json');

        // return $response;
        return $this->handleView($this->view($data, 200));
    } // "get_portfolio_instruments"   [GET] /portfolio/instruments/{slug}
}
