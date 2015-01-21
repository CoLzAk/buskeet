<?php

namespace Colzak\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Colzak\NotificationBundle\Document\Notification;

class HomeController extends Controller
{
    public function indexAction()
    {
        if (!is_object($this->get('security.context')->getToken()->getUser())) {
            return $this->render('ColzakStaticBundle:Home:index.html.twig');
        }
        return new RedirectResponse($this->container->get('router')->generate('colzak_user_feed'));
    }

    public function aboutAction() {
    	return $this->render('ColzakStaticBundle:Home:about.html.twig');
    }

    public function cguAction() {
    	return $this->render('ColzakStaticBundle:Home:cgu.html.twig');
    }

    public function privacyAction() {
    	return $this->render('ColzakStaticBundle:Home:privacy.html.twig');
    }

    public function contactAction(Request $request) {
        $dm = $this->get('doctrine_mongodb')->getManager();

        if ($request->isMethod('POST')) {
            $notification = new Notification();
            $notification->setStatus(Notification::STATUS_PENDING);
            $notification->setFrom($this->getRequest()->get('_contact_email'));
            $notification->setFromName($this->getRequest()->get('_contact_name'));
            $notification->setTo('contact@buskeet.com');
            $notification->setSubject($this->getRequest()->get('_contact_subject'));
            $notification->setContent($this->getRequest()->get('_contact_message'));
            $dm->persist($notification);
            $dm->flush();

             $request->getSession()->getFlashBag()->add(
                'success',
                'Message envoyé ! Merci !'
            );
        }

        return $this->render('ColzakStaticBundle:Home:contact.html.twig');
    }

    public function testAction() {
        return $this->render('ColzakStaticBundle:Home:test.html.twig');
    }
}
