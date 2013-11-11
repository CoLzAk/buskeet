<?php

namespace Colzak\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//test
use Colzak\PortfolioBundle\Form\Type\InstrumentFormType;
use Colzak\PortfolioBundle\Document\Instrument;
use Colzak\PortfolioBundle\Document\InstrumentType;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$dm = $this->container->get('doctrine_mongodb')->getManager();
        $instrumentType = $dm->getRepository('ColzakPortfolioBundle:InstrumentType')->findOneByCategory('CORDES');
        $instrument = new Instrument();
        $instrument->setName('piano');
        $instrument->setInstrumentType($instrumentType);
        // $instrumentForm = $this->container->get('form.factory')->create

        $dm->persist($instrument);
        $dm->flush();
        return $this->render('ColzakPortfolioBundle:Default:index.html.twig', array('name' => $name));
    }
}
