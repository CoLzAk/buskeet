<?php

namespace Colzak\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Colzak\PortfolioBundle\Document\Instrument;
use Colzak\PortfolioBundle\Form\Type\InstrumentFormType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('ColzakAdminBundle:Admin:index.html.twig');
    }

    public function usersAction() {
    	$dm = $this->get('doctrine_mongodb')->getManager();
    	$users = $dm->getRepository('ColzakUserBundle:User')->findAll();
    	return $this->render('ColzakAdminBundle:Admin:users.html.twig', array('users' => $users));
    }

    public function eventsAction() {
    	// $dm = $this->get('doctrine_mongodb')->getManager();
    	// $instruments = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findAll();
    	// return $this->render('ColzakAdminBundle:Admin:list.html.twig', array('items' => $instruments));

    }

    public function instrumentsAction() {
    	$dm = $this->get('doctrine_mongodb')->getManager();
    	$instruments = $dm->getRepository('ColzakPortfolioBundle:Instrument')->findAll();
    	return $this->render('ColzakAdminBundle:Admin:instruments.html.twig', array('instruments' => $instruments));
    }

    public function addInstrumentsAction(Request $request) {
    	$dm = $this->get('doctrine_mongodb')->getManager();
    	$instrument = new Instrument();
    	$form = $this->get('form.factory')->create(new InstrumentFormType(), $instrument);

    	if ($request->isMethod('POST')) {
    		$form->bind($request);

    		if ($form->isValid()) {
    			$dm->persist($instrument);
    			$dm->flush();
    		}
    	}

    	return $this->render('ColzakAdminBundle:Admin:add_instruments.html.twig', array('form' => $form->createView()));
    }
}
