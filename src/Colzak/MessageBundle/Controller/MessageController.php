<?php

namespace Colzak\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Colzak\MessageBundle\Document\Message;
use Colzak\MessageBundle\Document\Thread;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MessageController extends Controller
{
	public function lastThreadAction() {
	    $dm = $this->get('doctrine_mongodb')->getManager();
	    $user = $this->get('security.context')->getToken()->getUser();
	    $profile = $user->getProfile();
	    $limit = 5;
	    $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getLastThreads($profile, $limit);

	    return $this->render('ColzakMessageBundle:Message:partials/last_threads.html.twig', array('threads' => $threads));
	}

	public function threadAction($threadId) {
	    // $user = $this->get('security.context')->getToken()->getUser();
	    // $profile = $user->getProfile();
	    // $dm = $this->get('doctrine_mongodb')->getManager();
	    // if (null === $threadId) {
	    //     $limit = 1;
	    //     $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getLastThreads($profile, $limit);
	    //     $thread = $threads[0];
	    // } else {
	    //     $thread = $dm->getRepository('ColzakMessageBundle:Thread')->find($threadId);
	    // }
	    return $this->render('ColzakMessageBundle:Message:thread.html.twig', array('threadId' => $threadId));
	}

	public function inboxAction() {
	    $user = $this->get('security.context')->getToken()->getUser();
	    $profile = $user->getProfile();
	    $dm = $this->get('doctrine_mongodb')->getManager();
	    $limit = 1;
	    $threads = $dm->getRepository('ColzakMessageBundle:Thread')->getLastThreads($profile, $limit);

	    if (count($threads) > 0) {
	    	$thread = $threads[0];
	    	return new RedirectResponse($this->get('router')->generate('colzak_user_thread', array('threadId' => $thread->getId())));
	    } else {
	    	return $this->render('ColzakMessageBundle:Message:thread.html.twig', array('threadId' => null));
	    }
	}
}

