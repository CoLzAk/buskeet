<?php

// src/Colzak/UserBundle/Controller/UsersController.php

namespace Colzak\UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;

class UsersController extends BaseController
{
    /**
     * GET Route annotation.
     * @Get("/users/{username}/")
     * @Route(options={"segment_separators"={0="/"}})
     */
    public function getUserAction($username) {
    	$dm = $this->container->get('doctrine_mongodb')->getManager();
    	if ($username == 'me') {
    		$data = $this->container->get('security.context')->getToken()->getUser()->getProfile();
    	} else {
    		$user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);
    		$data = $user;
    	}
        return $this->handleView($this->view($data, 200));
    } // "get_user"     [GET] /users/{username}

    /**
     * GET Route annotation.
     * @Put("/users/{username}/")
     */
    public function putUserAction($username)
    {
        // the actual user
        $owner = $this->get('security.context')->getToken()->getUser();
        if (!is_object($owner) || !$owner instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        // the target user
        $dm = $this->container->get('doctrine_mongodb')->getManager();

        $request = $this->getRequest(); 

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $updatedUser = $serializer->deserialize($request->getContent(), 'Colzak\UserBundle\Document\User', 'json');
            var_dump($updatedUser);
        }

        // $user = $dm->merge($updatedUser);
        var_dump($user);
        // $user->getProfile()->setUser($user);
        $dm->flush();

        $data = $user;

        return $this->handleView($this->view($data, 200));

    } // "put_user"      [PUT] /users/{username}
}
