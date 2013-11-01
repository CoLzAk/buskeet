<?php
// src/Colzak/UserBundle/Controller/RegistrationController.php

namespace Colzak\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegistrationController extends BaseController
{
    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return new RedirectResponse($this->container->get('router')->generate('colzak_user_homepage', array('username' => $user->getUsername())));
    }
}