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
use Colzak\NotificationBundle\Document\Notification;

class MessagesController extends BaseController
{
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

        //Notify user about that (transform notif)
        $senderEmail = $user->getEmail();
        $recipientUser = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($recipient->getUsername());
        $recipientEmail = $recipientUser->getEmail();
        $notification = new Notification();
        $notification->setStatus(Notification::STATUS_PENDING);
        $notification->setFrom($senderEmail);
        $notification->setFromName('notify@buskeet.com');
        $notification->setTo($recipientEmail);
        $notification->setSubject($sender->getFirstname().' vous à envoyé un message');
        $notification->setContent($this->render('ColzakNotificationBundle:Mail:new_mail.html.twig', array('recipient' => $recipientUser)));

        $dm->persist($notification);

        $dm->flush();

        return $this->handleView($this->view($thread, 200));
    } // "post_users_files"   [POST] /users/{id}/files

    /**
     * GET Route annotation.
     * @Get("/thread/{threadId}/messages")
     */
    public function getThreadMessagesAction($threadId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $thread = $dm->getRepository('ColzakMessageBundle:Thread')->find($threadId);
        return $this->handleView($this->view($thread->getMessages(), 200));
    }

    /**
     * GET Route annotation.
     * @Get("/users/{userId}/threads")
     */
    public function getThreadsAction($userId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getLastThreads($user->getProfile(), 10);

        return $this->handleView($this->view($threads, 200)); 
    }

    /**
     * GET Route annotation.
     * @Post("/thread/{threadId}/messages")
     */
    public function postThreadMessageAction($threadId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $sender = $user->getProfile();
        $data = json_decode($this->container->get('request')->getContent());
        $recipient = $dm->getRepository('ColzakUserBundle:Profile')->find($data->recipientId);
        $thread = $dm->getRepository('ColzakMessageBundle:Thread')->find($threadId);

        $message = new Message();
        $message->setMessage($data->message);
        $message->setSender($sender);
        $message->setRecipient($recipient);

        $thread->addMessage($message);

        $dm->persist($thread);

        //Notify user about that (transform notif)
        $senderEmail = $user->getEmail();
        $recipientUser = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($recipient->getUsername());
        $recipientEmail = $recipientUser->getEmail();
        $notification = new Notification();
        $notification->setStatus(Notification::STATUS_PENDING);
        $notification->setFrom($senderEmail);
        $notification->setFromName('notify@buskeet.com');
        $notification->setTo($recipientEmail);
        $notification->setSubject($sender->getFirstname().' vous à envoyé un message');
        $notification->setContent($this->render('ColzakNotificationBundle:Mail:new_mail.html.twig', array('recipient' => $recipientUser)));

        $dm->persist($notification);

        $dm->flush();
        
        return $this->handleView($this->view($message, 200));
    }
}
