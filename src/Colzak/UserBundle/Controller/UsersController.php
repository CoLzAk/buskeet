<?php

// src/Colzak/UserBundle/Controller/UsersController.php

namespace Colzak\UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\UserBundle\Model\UserInterface;

class UsersController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{username}/")
     */
    public function getUserAction($username) {
    	$dm = $this->container->get('doctrine_mongodb')->getManager();
    	if ($username == 'me') {
    		$data = $this->container->get('security.context')->getToken()->getUser()->getProfile();
    	} else {
    		$user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);
    		$data = $user->getProfile();
    	}
        return $this->handleView($this->view($data, 200));
    } // "get_user"     [GET] /users/{username}/
}
