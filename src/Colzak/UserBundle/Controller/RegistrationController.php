<?php
// src/Colzak/UserBundle/Controller/RegistrationController.php

namespace Colzak\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Colzak\UserBundle\Document\Profile;
use Colzak\NotificationBundle\Document\Notification;

class RegistrationController extends BaseController
{
    // protected function register(Request $request) {
    //     $dm = $this->container->get('doctrine_mongodb')->getManager();
    //     /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    //     $formFactory = $this->container->get('fos_user.registration.form.factory');
    //     /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
    //     $userManager = $this->container->get('fos_user.user_manager');
    //     /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    //     $dispatcher = $this->container->get('event_dispatcher');

    //     $user = $userManager->createUser();
    //     $profile = new Profile();
    //     $user->setProfile($profile);
    //     $user->setEnabled(true);

    //     $event = new GetResponseUserEvent($user, $request);
    //     $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

    //     if (null !== $event->getResponse()) {
    //         return $event->getResponse();
    //     }

    //     $form = $formFactory->createForm();
    //     $form->setData($user);

    //     if ('POST' === $request->getMethod()) {
    //         $form->bind($request);

    //         if ($form->isValid()) {
    //             $event = new FormEvent($form, $request);
    //             $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

    //             $profile = $user->getProfile();
    //             $profile->setUsername($user->getUsername());
    //             $dm->persist($profile);
    //             $dm->flush();

    //             $userManager->updateUser($user);

    //             if (null === $response = $event->getResponse()) {
    //                 $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
    //                 $response = new RedirectResponse($url);
    //             }

    //             $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

    //             return $response;
    //         }
    //     }

    //     return $form;
    // }

    public function registerAction(Request $request)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $profile = new Profile();
        $user->setProfile($profile);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $profile = $user->getProfile();
                $profile->setUsername($user->getUsername());
                $dm->persist($profile);

                //Send notif
                $notification = new Notification();
                $notification->setStatus(Notification::STATUS_PENDING);
                $notification->setFrom('no.reply@buskeet.com');
                $notification->setFromName('Buskeet');
                $notification->setTo($user->getEmail());
                $notification->setSubject('Inscription');
                $notification->setContent($this->container->get('templating')->render('ColzakNotificationBundle:Mail:email_confirmed_registration.html.twig', array('user' => $user)));

                $dm->persist($notification);

                $dm->flush();

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    public function embeddedRegisterAction(Request $request) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $profile = new Profile();
        $user->setProfile($profile);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $profile = $user->getProfile();
                $profile->setUsername($user->getUsername());
                $dm->persist($profile);

                //Send notif
                $notification = new Notification();
                $notification->setStatus(Notification::STATUS_PENDING);
                $notification->setFrom('no.reply@buskeet.com');
                $notification->setFromName('Buskeet');
                $notification->setTo($user->getEmail());
                $notification->setSubject('Inscription');
                $notification->setContent($this->container->get('templating')->render('ColzakNotificationBundle:Mail:email_confirmed_registration.html.twig', array('user' => $user)));

                $dm->persist($notification);


                $dm->flush();

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse('ColzakUserBundle:Registration:embedded_register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return new RedirectResponse($this->container->get('router')->generate('colzak_user_homepage', array('username' => $user->getUsername())));
    }
}