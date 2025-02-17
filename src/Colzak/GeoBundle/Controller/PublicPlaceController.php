<?php

namespace Colzak\GeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Colzak\GeoBundle\Document\PublicPlace;
use Colzak\GeoBundle\Form\Type\PublicPlaceFormType;
use Symfony\Component\HttpFoundation\Request;

class PublicPlaceController extends Controller
{
    public function listAction($locality) {
        // $dm = $this->get('doctrine_mongodb')->getManager();
        // $publicPlaces = $dm->getRepository()
    }

    public function addAction(Request $request)
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$dm = $this->get('doctrine_mongodb')->getManager();
    	$publicPlace = new PublicPlace();
    	$publicPlace->setCreatedBy($user->getProfile());

    	$form = $this->get('form.factory')->create(new PublicPlaceFormType(), $publicPlace);

    	if ($request->isMethod('POST')) {
    		$form->bind($request);

    		if ($form->isValid()) {
    			$dm->persist($publicPlace);
    			$dm->flush();
                $this->container->get('session')->getFlashBag()->add(
                    'success',
                    'Lieu ajouté avec succès ! Merci de votre contribution'
                );
    		} else {
                $this->container->get('session')->getFlashBag()->add(
                    'error',
                    'Une erreur s\'est produite, veuillez réessayer ultérieurement'
                );
            }
    	}

        return $this->render('ColzakGeoBundle:PublicPlace:add.html.twig', array('form' => $form->createView()));
    }
}
