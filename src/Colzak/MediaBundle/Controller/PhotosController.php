<?php

namespace Colzak\MediaBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\UserBundle\Model\UserInterface;
use Colzak\MediaBundle\Document\Photo;
use Colzak\MediaBundle\Form\Type\PhotoFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Colzak\UserBundle\Document\Movement;
use Colzak\UserBundle\Document\MovementDetail;

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

        (count($user->getProfile()->getPhotos()) === 0 ? $photo->setIsProfilePicture(true) : $photo->setIsProfilePicture(false));

        if ($request->files->get('photos') !== NULL) $photo->setFile($request->files->get('photos'));

        if ($photoForm->isValid()) {

            //add movement
            $movement = new Movement();
            $movement->setProfile($user->getProfile());
            $movementDetail = new MovementDetail();
            $movementDetail->setAction(MovementDetail::ACTION_ADDED_PHOTO);
            $movementDetail->setPhoto($photo);
            $movement->setMovementDetail($movementDetail);
            $dm->persist($movement);

            $dm->persist($photo);
            $dm->flush();

            $data = $photo;
        } else {
            die($photoForm->getErrorsAsString());
        }

        return $this->handleView($this->view($data, 200));
    } // "post_users_files"   [POST] /users/{id}/files

    /**
     * DELETE Route annotation.
     * @Delete("/users/{userId}/photos/{photoId}")
     */
    public function deleteUserPhotosAction($userId, $photoId) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $photos = $user->getProfile()->getPhotos();
        $photo = $dm->getRepository('ColzakMediaBundle:Photo')->find($photoId);

        $dm->remove($photo);
        $dm->flush();

        return $this->handleView($this->view($photos, 200));
        // $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
    }

    /**
     * PUT Route annotation.
     * @Put("/users/{userId}/photos/{photoId}")
     */
    public function putUserPhotosAction($userId, $photoId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $targetPhoto = $dm->getRepository('ColzakMediaBundle:Photo')->find($photoId);

        $photos = $user->getProfile()->getPhotos();

        foreach ($photos as $photo) {
            $photo->setIsProfilePicture(false);
        }

        $request = $this->getRequest();

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $updatedPhoto = $serializer->deserialize($request->getContent(), 'Colzak\MediaBundle\Document\Photo', 'json');
        }

        $updatedPhoto->setProfile($user->getProfile());
        $targetPhoto = $dm->merge($updatedPhoto);
        
        //add movement
        $movement = new Movement();
        $movement->setProfile($user->getProfile());
        $movementDetail = new MovementDetail();
        $movementDetail->setAction(MovementDetail::ACTION_CHANGED_PROFILE_PHOTO);
        $movementDetail->setPhoto($photo);
        $movement->setMovementDetail($movementDetail);
        $dm->persist($movement);

        $dm->flush();
        $data = $updatedPhoto;

        return $this->handleView($this->view($photos, 200));
        // $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
    }
}