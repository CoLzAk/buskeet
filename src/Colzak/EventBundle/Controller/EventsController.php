<?php

namespace Colzak\EventBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends BaseController {


    public function viewAction($eventId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $event = $dm->getRepository('ColzakEventBundle:Event')->find($eventId);
        $isParticipating = FALSE;

        foreach ($event->getParticipants() as $participant) {
            if ($participant->getId() === $user->getProfile()->getId()) {
                $isParticipating = TRUE;
            }
        }

        return $this->render('ColzakEventBundle:Event:view.html.twig', array(
            'event' => $event,
            'isParticipating' => $isParticipating
        ));
    }

    public function toggleParticipateAction($eventId) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $event = $dm->getRepository('ColzakEventBundle:Event')->find($eventId);
        $participants = $event->getParticipants();
        $user = $this->get('security.context')->getToken()->getUser();
        $isParticipating = FALSE;

        //Hack: wtf ? dunno...
        $user->getProfile()->setDistance(0);

        if (count($participants) > 0) {
            foreach ($participants as $participant) {
                if ($participant->getId() === $user->getProfile()->getId()) {
                    $event->removeParticipant($participant);
                    break;
                } else {
                    $event->addParticipant($user->getProfile());
                    $isParticipating = TRUE;
                }
            }
        } else {
            $event->addParticipant($user->getProfile());
            $isParticipating = TRUE;
        }

        $dm->persist($event);
        $dm->flush();

        return $this->render('ColzakEventBundle:Event:view.html.twig', array(
            'event' => $event,
            'isParticipating' => $isParticipating
        ));
    }

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
    } // "get_users_files"   [GET] /users/{userId}/events

    /**
     * GET Route annotation.
     * @Get("/events")
     */
    public function getEventsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $q = $dm->getRepository('ColzakEventBundle:Event')->findAll();
        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{userId}/events

    /**
     * PUT Route annotation.
     * @Put("/events/{id}")
     */
    public function putEventsAction($id) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $event = $dm->getRepository('ColzakEventBundle:Event')->find($id);

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $serializer = $this->get('jms_serializer');
            var_dump($request->getContent());
            $updatedEvent = $serializer->deserialize($request->getContent(), 'Colzak\EventBundle\Document\Event', 'json');
        }
        $event = $dm->merge($updatedEvent);
        $dm->flush();

        $data = $event;

        return $this->handleView($this->view($data, 200));
    }

    /**
     * PUT Route annotation.
     * @Post("/events/{id}/participate/{userId}")
     */
    public function postEventsUserParticipateAction($id, $userId) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $event = $dm->getRepository('ColzakEventBundle:Event')->find($id);
        $participants = $event->getParticipants();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        //Hack: wtf ? dunno...
        $user->getProfile()->setDistance(0);

        if (count($participants) > 0) {
            foreach ($participants as $participant) {
                if ($participant->getId() === $user->getProfile()->getId()) {
                    $event->removeParticipant($participant);
                    break;
                } else {
                    $event->addParticipant($user->getProfile());
                }
            }
        } else {
            $event->addParticipant($user->getProfile());
        }

        $dm->persist($event);
        $dm->flush();

        return $this->handleView($this->view($event, 200));
    }

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
     * PUT Route annotation.
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
        $dm->flush();

        $data = $event;

        return $this->handleView($this->view($data, 200));
    }

    /**
     * DELETE Route annotation.
     * @Delete("/users/{userId}/events/{id}")
     */
    public function deleteUserEventsAction($userId, $id) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $event = $dm->getRepository('ColzakEventBundle:Event')->find($id);

        $dm->remove($event);
        $dm->flush();

        return $this->handleView($this->view($user->getProfile()->getEvents(), 200));
    }
}