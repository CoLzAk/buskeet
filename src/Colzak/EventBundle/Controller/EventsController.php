<?php

namespace Colzak\EventBundle\Controller;

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

class EventsController extends BaseController {

	/**
     * GET Route annotation.
     * @Get("/users/{userId}/events")
     */
    public function getUserEventsAction($userId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $q = $dm->createQueryBuilder('ColzakEventBundle:Event');
        $q->field('profile')->references($user->getProfile());
        $data = $q->getQuery()->execute();

        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{userId}/files

    /**
     * POST Route annotation.
     * @Post("/users/{userId}/events")
     */
    public function postUserEventsAction($userId)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $serializer = $this->get('jms_serializer');
            $event = $serializer->deserialize($request->getContent(), 'Colzak\EventBundle\Document\Event', 'json');
        }

        $event->setProfile($user->getProfile());
        $dm->persist($event);
        $dm->flush();

        $data = $event;

        return $this->handleView($this->view($data, 200));
    } // "post_users_files"   [POST] /users/{id}/files

    /**
     * POST Route annotation.
     * @Put("/users/{userId}/events/{id}")
     */
    public function putUserEventsAction($userId, $id) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $serializer = $this->get('jms_serializer');
            $updatedEvent = $serializer->deserialize($request->getContent(), 'Colzak\EventBundle\Document\Event', 'json');
        }

        $updatedEvent->setProfile($user->getProfile());
        $event = $dm->merge($updatedEvent);
        // $dm->persist($event);
        $dm->flush();

        $data = $event;

        return $this->handleView($this->view($data, 200));
    }
}