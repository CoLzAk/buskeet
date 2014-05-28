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
use Colzak\PortfolioBundle\Document\Instrument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class InstrumentsController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/instruments/{slug}")
     */
    public function getInstrumentsAction($slug) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findInstrumentsBySlug($slug)->toArray();

        return $this->handleView($this->view($data, 200));
    } // "get_portfolio_instruments"   [GET] /portfolio/instruments/{slug}

    /**
     * GET Route annotation.
     * @Get("/instruments")
     */
    public function getAllInstrumentsAction() {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findAll();

        return $this->handleView($this->view($data, 200));
    } // "get_portfolio_instruments"   [GET] /portfolio/instruments/{slug}
}
