<?php

// src/Colzak/SearchBundle/Controller/SearchController.php

namespace Colzak\SearchBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends BaseController
{
    public function indexAction($localization, Request $request) {
        $searchParams = $this->getSearchParams($request);

        $queryUrl = array(
            'localization' => $localization,
            'searchParams' => $searchParams
        );

        return $this->render('ColzakSearchBundle:Search:index.html.twig', array('queryUrl' => $queryUrl));
    }

    /**
     * GET Route annotation.
     * @Get("/search/{localization}")
     */
    public function getSearchAction($localization, Request $request) {
        $dm    = $this->get('doctrine_mongodb')->getManager();

        $searchParams = $this->getSearchParams($request);

        $data = $dm->getRepository('ColzakUserBundle:Profile')->profileFilteredSearch($searchParams);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data,
            $this->get('request')->query->get('page', 1)/*page number*/,
            25 //number of elements per page
        );

        return $this->handleView($this->view($pagination, 200));
    } // "get_search"   [GET] /search/{localization}

    protected function getSearchParams(Request $request) {
        $searchParams = array();
        (!$request->get('lat') ?: $searchParams['lat'] = $request->get('lat'));
        (!$request->get('lng') ?: $searchParams['lng'] = $request->get('lng'));
        (!$request->get('radius') ?: $searchParams['radius'] = $request->get('radius'));
        (!$request->get('age') ?: $searchParams['age'] = $request->get('age'));
        (!$request->get('gender') ?: $searchParams['gender'] = $request->get('gender'));
        (!$request->get('category') ?: $searchParams['category'] = $request->get('category'));
        return $searchParams;
    }
}