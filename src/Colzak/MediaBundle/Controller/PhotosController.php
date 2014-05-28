<?php

namespace Colzak\MediaBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;
use Colzak\MediaBundle\Document\Photo;
use Colzak\MediaBundle\Form\Type\PhotoFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PhotosController extends BaseController {

	/**
     * GET Route annotation.
     * @Get("/users/{userId}/photos")
     */
    public function getUserPhotosAction($userId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $q = $dm->createQueryBuilder('ColzakMediaBundle:Photo');
        $q->field('profile')->references($user->getProfile());
        $data = $q->getQuery()->execute();

        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{userId}/files

    /**
     * POST Route annotation.
     * @Post("/users/{userId}/photos")
     */
    public function postUserPhotosAction($userId)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $request = $this->container->get('request');
        $photo = new Photo();
        $photoForm = $this->container->get('form.factory')->create(new PhotoFormType(), $photo);
        $photoForm->bind($request);

        $photo->setProfile($user->getProfile());

        $photo->setIsProfilePicture(false);

        if ($request->files->get('photos') !== NULL) $photo->setFile($request->files->get('photos'));

        if ($photoForm->isValid()) {
            $dm->persist($photo);
            $dm->flush();

            $data = $photo;

        } else {
            die;
        }

        return $this->handleView($this->view($data, 200));
    } // "post_users_files"   [POST] /users/{id}/files
}