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
    public function indexAction($username)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->findOneByUsername($username);

        //First time only
        if (null === $user->getProfile()->getPortfolio()) {
            $portfolio = new Portfolio();
            $portfolio->setProfile($user->getProfile());
            $dm->persist($portfolio);
            $dm->flush();
        }

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

    public function testAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $event = new Event();
        $event->setProfile($user->getProfile());
        $event->setStartDate(new \Datetime());
        $event->setEndDate(new \Datetime());
        $event->setTitle('Test');
        $event->setContent('Ceci est un muthafukin test muthafukaz');

        $dm->persist($event);
        $dm->flush();

        // $portfolio = new Portfolio();
        // $portfolio->setProfile($user->getProfile());

        // $iGuitare = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findOneByName('Guitare');
        // $iPiano = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findOneByName('Piano');
        // $iCajon = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findOneByName('Cajon');

        // $portfolioInstrument1 = new PortfolioInstrument();
        // $portfolioInstrument1->setLevel(PortfolioInstrument::LEVEL_AMATEUR);
        // $portfolioInstrument1->setInstrument($iGuitare);
        // $portfolioInstrument1->setPortfolio($portfolio);

        // $portfolioInstrument2 = new PortfolioInstrument();
        // $portfolioInstrument2->setLevel(PortfolioInstrument::LEVEL_AMATEUR);
        // $portfolioInstrument2->setInstrument($iCajon);
        // $portfolioInstrument2->setPortfolio($portfolio);

        // $portfolioInstrument3 = new PortfolioInstrument();
        // $portfolioInstrument3->setLevel(PortfolioInstrument::LEVEL_BEGINNER);
        // $portfolioInstrument3->setInstrument($iPiano);
        // $portfolioInstrument3->setPortfolio($portfolio);

        // $portfolio->addPortfolioInstrument($portfolioInstrument1);
        // $portfolio->addPortfolioInstrument($portfolioInstrument2);
        // $portfolio->addPortfolioInstrument($portfolioInstrument3);


        // $dm->persist($portfolio);
        // $dm->flush();
        


        // $form = $this->get('form.factory')->create(new PortfolioInstrumentFormType(), $portfolioInstrument);
    }
}
