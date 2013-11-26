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
use Colzak\PortfolioBundle\Entity\Portfolio;
use Colzak\PortfolioBundle\Entity\Objective;
use Colzak\PortfolioBundle\Entity\Instrument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PortfoliosController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{id}/portfolio")
     */
    public function getUserPortfolioAction($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('ColzakUserBundle:User')->find($id);
        $data = $em->getRepository('ColzakPortfolioBundle:Portfolio')->findByProfile($user->getProfile());

        return $this->handleView($this->view($data, 200));
    } // "get_users_portfolio"   [GET] /users/{id}/portfolio

    /**
     * GET Route annotation.
     * @Post("/users/{id}/portfolio")
     */
    public function postUserPortfolioAction($id)
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


    // Construct the portfolio
    public function managePortfolio($reqPortfolio) {
        $em = $this->get('doctrine')->getManager();
        $portfolio = (!isset($reqPortfolio['id']) ? new Portfolio() : $em->getRepository('ColzakPortfolioBundle:Portfolio')->find($reqPortfolio['id']));
        $portfolio->setTargetsDescription($reqPortfolio['targets_description']);
        if (isset($reqPortfolio['targets'])) {
            foreach ($reqPortfolio['targets'] as $target) {
                $portfolio->addTarget($em->getRepository('ColzakPortfolioBundle:Instrument')->find($target['id']));
            }
        }
        if (isset($reqPortfolio['instruments'])) {
            foreach ($reqPortfolio['instruments'] as $instrument) {
                $portfolio->addInstrument($em->getRepository('ColzakPortfolioBundle:Instrument')->find($instrument['id']));
            }
        }
        if (isset($reqPortfolio['objectives'])) {
            foreach ($reqPortfolio['objectives'] as $objective) {
                $oObjective = new Objective();
                $oObjective->setTitle($objective['title']);
                $oObjective->setContent($objective['content']);
                $oObjective->setStartDate(new \DateTime($objective['start_date']));
                $oObjective->setEndDate(new \DateTime($objective['end_date']));
                $oObjective->setPortfolio($portfolio);
                $portfolio->addObjective($oObjective);
            }
        }
        return $portfolio;
    }
}
