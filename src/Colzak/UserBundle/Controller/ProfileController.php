<?php

namespace Colzak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Colzak\PortfolioBundle\Document\Instrument;
use Colzak\PortfolioBundle\Document\Portfolio;
use Colzak\PortfolioBundle\Document\PortfolioInstrument;
use Colzak\PortfolioBundle\Form\Type\PortfolioInstrumentFormType;
use Colzak\EventBundle\Document\Event;

class ProfileController extends Controller
{
    public function indexAction($username, $slug1, $slug2)
    {
        if ('' !== $slug1) {
            return new RedirectResponse($this->container->get('router')->generate('colzak_user_homepage', array('username' => $username)));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);

        $profilePicture = $user->getProfile()->getPhotos()[0];

        foreach ($user->getProfile()->getPhotos() as $photo) {
            if ($photo->getIsProfilePicture()) {
                $profilePicture = $photo;
            }
        }

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
        
        $q = $dm->createQueryBuilder('ColzakUserBundle:Profile');
        $q->sort('createdAt', 'desc');
        $q->limit(12);
        $users = $q->getQuery()->execute()->toArray();

        return $this->container->get('templating')->renderResponse('ColzakUserBundle:Profile:partials/last_users.html.twig', array(
            'users' => $users
        ));
    }
}
