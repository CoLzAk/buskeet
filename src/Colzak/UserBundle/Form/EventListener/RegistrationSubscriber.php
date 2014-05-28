<?php

namespace Colzak\UserBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Event subscriber used to generate unique username during the registration process
 */
class RegistrationSubscriber implements EventSubscriberInterface
{
    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }


    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_bind
        // event and that the preBind method should be called.
        return array(FormEvents::PRE_BIND => 'preBind');
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        if (null === $data) return;

        $data['username'] = $this->dm->getRepository('ColzakUserBundle:User')->generateUniqueUsername($data);

        $event->setData($data);
    }
}