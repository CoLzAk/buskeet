<?php

namespace Colzak\MessageBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use Colzak\MessageBundle\Document\Message;
use Colzak\MessageBundle\Document\Thread;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MessagesController extends BaseController
{
    public function lastThreadAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $profile = $user->getProfile();
        $test = $dm->getRepository('ColzakUserBundle:Profile')->find('53c68ff369032d280c000000');
        $limit = 5;

        // $threads = 'test';
        $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getLastThreads($profile, $limit);
        // $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getByParticipants($profile, $test);
        \Doctrine\Common\Util\Debug::dump($threads);

        return $this->render('ColzakMessageBundle:Message:partials/last_threads.html.twig', array('threads' => $threads));
    }

    public function threadAction($threadId) {
        //
    }

    /**
     * POST Route annotation.
     * @Post("/messages/{recipientId}")
     */
    public function postMessagesAction($recipientId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $sender = $user->getProfile();
        $recipient = $dm->getRepository('ColzakUserBundle:Profile')->find($recipientId);
        $participants = array($sender, $recipient);
        $data = json_decode($this->container->get('request')->getContent());

        $thread = $dm->getRepository('ColzakMessageBundle:Thread')->getByParticipants($sender, $recipient);

        if (count($thread) === 0) {
        	$thread = new Thread();
        	$thread->addParticipant($sender);
        	$thread->addParticipant($recipient);
        } else {
        	$thread = $thread[0];
        }

        $message = new Message();
    	$message->setMessage($data->message);
    	$message->setSender($sender);
    	$message->setRecipient($recipient);

    	$thread->addMessage($message);

    	$dm->persist($thread);
    	$dm->flush();
    	
        return $this->handleView($this->view($thread, 200));
    } // "post_users_files"   [POST] /users/{id}/files
}
