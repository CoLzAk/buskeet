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
use Colzak\PortfolioBundle\Document\Instrument;
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
     * @Put("/users/{id}/portfolio/{portfolioId}")
     */
    public function putUserAction($id, $portfolioId)
    {
        // the actual user
        $owner = $this->get('security.context')->getToken()->getUser();
        if (!is_object($owner) || !$owner instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $dm = $this->container->get('doctrine_mongodb')->getManager();

        $request = $this->getRequest(); 

        $portfolio = $dm->getRepository('ColzakPortfolioBundle:Portfolio')->find($portfolioId);

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            var_dump($request->getContent()); die();
            // $updatedPortfolio = json_decode($request->getContent(), true);
            // foreach ($updatedPortfolio['targets'] as $target) {
            //     $instrument = new Instrument();
            //     $instrument->
            //     $portfolio->addTarget($target);
            // }
            // $updatedPortfolio = $serializer->deserialize($request->getContent(), 'Colzak\PortfolioBundle\Document\Portfolio', 'json');
        }
        var_dump($updatedPortfolio); die();
        //$portfolio->setProfile($owner->getProfile());
        $dm->flush();
        $data = $portfolio;

        return $this->handleView($this->view($data, 200));

    } // "put_users_portfolio"      [PUT] /users/{id}/portfolio/{portfolioId}


    /**
     * GET Route annotation.
     * @Get("/portfolio/instruments")
     */
    // public function getPortfolioInstrumentsAction(Request $request) {
    //     $dm = $this->container->get('doctrine_mongodb')->getManager();

    //     $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findInstrumentsBySlug($request->query->get('term'))->toArray();
    //     // $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findAll()->toArray();

    //     // $serializer = $this->get('jms_serializer');
    //     // $response = new Response(json_encode(array('data' => $data)));
    //     // $response->headers->set('Content-Type', 'application/json');

    //     // return $response;
    //     return $this->handleView($this->view($data, 200));
    // } // "get_portfolio_instruments"   [GET] /portfolio/instruments

    /**
     * GET Route annotation.
     * @Get("/portfolio/instruments/{slug}")
     */
    public function getPortfolioInstrumentsAction($slug) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $data = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findInstrumentsBySlug($slug)->toArray();
        return $this->handleView($this->view($data, 200));
    } // "get_portfolio_instruments"   [GET] /portfolio/instruments/{slug}
}
