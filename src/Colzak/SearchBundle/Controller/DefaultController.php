<?php

namespace Colzak\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($localization, Request $request)
    {
        return $this->render('ColzakSearchBundle:Default:index.html.twig', array('localization' => $localization));
    }
}
