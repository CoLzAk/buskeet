<?php

namespace Colzak\UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\FormEvent;
use Colzak\UserBundle\ColzakUserEvents;
use Colzak\UserBundle\Document\Profile;
use Colzak\NotificationBundle\Service\NotificationService;

class EmailSubscriber implements EventSubscriberInterface
{
    private $container;

    private $notificationService;

    public function __construct(
        ContainerInterface $container,
        NotificationService $notificationService
    ) {
        $this->container = $container;
        $this->notificationService = $notificationService;
    }

    public static function getSubscribedEvents()
    {
        return [
            ColzakUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        ];
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $profile = new Profile();
        $user->setProfile($profile);
        $user->setEnabled(true);

        $content = $this->container->get('templating')->render('ColzakNotificationBundle:Mail:email_confirmed_registration.html.twig', array('user' => $user));
        $this->getNotificationService()->push($user, $content);
    }

    public function getNotificationService()
    {
        return $this->notificationService;
    }
}
