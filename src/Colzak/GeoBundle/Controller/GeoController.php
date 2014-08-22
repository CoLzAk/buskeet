<?php

namespace Colzak\GeoBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GeoController extends BaseController {
	/**
     * GET Route annotation.
     * @Get("/geo/public/places")
     */
    public function getPublicPlacesAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $searchParams = array();
        $searchParams['lat'] = $request->get('lat');
		$searchParams['lng'] = $request->get('lng');
		// $searchParams['radius'] = $request->get('radius');
       	$data = $dm->getRepository('ColzakGeoBundle:PublicPlace')->getByCoordinates($searchParams);

        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{userId}/events
}