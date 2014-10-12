<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Colzak\PortfolioBundle\Document\Instrument;
use Colzak\PortfolioBundle\Document\Portfolio;
use Colzak\PortfolioBundle\Document\PortfolioInstrument;
use Colzak\PortfolioBundle\Form\Type\PortfolioInstrumentFormType;
use Colzak\EventBundle\Document\Event;
use Colzak\UserBundle\Form\Type\EmailFormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    public function indexAction($username, $slug1, $slug2)
    {
        if ('' !== $slug1) {
            return new RedirectResponse($this->container->get('router')->generate('colzak_user_homepage', array('username' => $username)));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);

        if (null === $user) {
            throw new NotFoundHttpException('Profile not found');
        }

        $profilePicture = $user->getProfile()->getProfilePhoto();
        if ($profilePicture === null) {
            $profilePicture = $user->getProfile()->getPhotos()[0];
        }

        // foreach ($user->getProfile()->getPhotos() as $photo) {
        //     if ($photo->getIsProfilePicture()) {
        //         $profilePicture = $photo;
        //     }
        // }

        return $this->render('ColzakUserBundle:Profile:index.html.twig', array(
            'profile' => $user->getProfile(),
            'profilePicture' => $profilePicture,
            'photos' => $user->getProfile()->getPhotos(),
            'userId' => $user->getId(), 
            'visitorId' => ($this->get('security.context')->isGranted('ROLE_USER') ? $this->get('security.context')->getToken()->getUser()->getId() : null))
        );
    }

    public function getLastRegisteredUsersAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $users = $dm->getRepository('ColzakUserBundle:Profile')->getLastRegisteredProfiles();

        return $this->render('ColzakUserBundle:Profile:partials/last_users.html.twig', array(
            'users' => $users
        ));
    }

    public function accountAction() {
        return $this->render('ColzakUserBundle:Profile:account.html.twig');
    }

    public function changeEmailAction() {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $form = $this->container->get('form.factory')->create(new EmailFormType(), $user);

        if ($this->container->get('request')->isMethod('POST')) {
            $form->bind($this->container->get('request'));

            if ($form->isValid()) {
                if (count($dm->getRepository('ColzakUserBundle:User')->findOneByEmail($user->getEmail())) > 0) {
                    $this->container->get('session')->getFlashBag()->add(
                        'error',
                        'l\'adresse "'.$user->getEmail().'" est déjà présente en base, vous ne pouvez donc pas l\'utiliser'
                    );

                    return new RedirectResponse($this->container->get('router')->generate('colzak_user_account'));
                }
                $dm->persist($user);
                $dm->flush();
            }
            return new RedirectResponse($this->container->get('router')->generate('colzak_user_account'));
        }

        return $this->render('ColzakUserBundle:Profile:partials/change_email.html.twig', array('form' => $form->createView()));
    }

    public function deleteAccountAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $user->getProfile()->setEnabled(false);
        $user->setDeleted(true);
        $user->setDeletedAt(new \Datetime());
        $user->setLocked(true);
        $dm->persist($user);
        $dm->flush();

        return new RedirectResponse($this->container->get('router')->generate('fos_user_security_logout'));
    }

    public function homeAction() {
        return $this->render('ColzakUserBundle:Profile:feeds.html.twig'); 
    }
}
