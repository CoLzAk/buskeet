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
    /**
     * GET Route annotation.
     * @Get("/search/{localization}/{category}")
     */
    public function getSearchAction($localization, $category, Request $request) {
        $em    = $this->get('doctrine')->getManager();
        $data = $em->getRepository('ColzakUserBundle:User')->findAll();

        return $this->handleView($this->view($data, 200));
    } // "get_search"   [GET] /search/{localization}/{category}
}