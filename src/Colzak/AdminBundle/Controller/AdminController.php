<?php

namespace Colzak\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Colzak\PortfolioBundle\Document\Instrument;
use Colzak\PortfolioBundle\Form\Type\InstrumentFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('ColzakAdminBundle:Admin:index.html.twig');
    }

    public function usersAction() {
    	$dm = $this->get('doctrine_mongodb')->getManager();
        // knp paginator to implement
    	$users = $dm->getRepository('ColzakUserBundle:User')->findAll();
    	return $this->render('ColzakAdminBundle:Admin:users.html.twig', array('users' => $users));
    }

    public function viewUserAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($id);

        return $this->render('ColzakAdminBundle:Admin:view_user.html.twig', array('user' => $user));
    }

    public function deleteUserAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($id);


        //Replace user / profile / photo / event / thread by lambda (like facebook's "Facebook User")
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

                return new RedirectResponse($this->get('router')->generate('colzak_admin_instruments'));
    		}
    	}

    	return $this->render('ColzakAdminBundle:Admin:add_instruments.html.twig', array('form' => $form->createView()));
    }

    public function deleteInstrumentsAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $instrument = $dm->getRepository('ColzakPortfolioBundle:Instrument')->find($id);

        if (NULL !== $instrument) {
            $dm->remove($instrument);
            $dm->flush();
        }

        return new RedirectResponse($this->get('router')->generate('colzak_admin_instruments'));
    }
}
