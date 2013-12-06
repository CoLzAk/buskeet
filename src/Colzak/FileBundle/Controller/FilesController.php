<?php

namespace Colzak\FileBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\UserBundle\Model\UserInterface;
use Colzak\FileBundle\Entity\File;
use Colzak\FileBundle\Form\Type\FileFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FilesController extends BaseController {

	/**
     * GET Route annotation.
     * @Get("/users/{id}/files")
     */
    public function getUserFilesAction($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('ColzakUserBundle:User')->find($id);
        $data = $em->getRepository('ColzakFileBundle:File')->findByProfile($user->getProfile());

        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{id}/files

    /**
     * POST Route annotation.
     * @Post("/users/{id}/files")
     */
    public function postUserFilesAction($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('ColzakUserBundle:User')->find($id);
        $request = $this->container->get('request');
        $file = new File();
        $fileForm = $this->container->get('form.factory')->create(new FileFormType(), $file);
        $fileForm->bind($request);

        $file->setName($user->getUsername());
        $file->setProfile($user->getProfile());
        $file->setProfilePicture(false);

        if (count($em->getRepository('ColzakFileBundle:File')->getByProfileAndFileType($user->getProfile()->getId())) == 0) {
            $file->setProfilePicture(true);
        }

        if ($request->files->get('photos') !== NULL) $file->setFile($request->files->get('photos'));

        if ($fileForm->isValid()) {
            $em->persist($file);
            $em->flush();

            $data = $file;

        } else {
            die;
        }

        return $this->handleView($this->view($data, 200));
    } // "post_users_files"   [POST] /users/{id}/files

    public function deleteUserFileAction($username, $id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('CaribooCNUserBundle:User')->loadUserByUsername($username);
        $file = $em->getRepository('CaribooCNFileBundle:File')->find($id);
        if ($file->getProfilePicture() === true) {
            $nextFile = $em->getRepository('CaribooCNFileBundle:File')->findOneByProfilePicture(false);
            $nextFile->setProfilePicture(true);
            $em->persist($nextFile);
        }

        if (!$file) {
             throw $this->createNotFoundException(
                'No file found for id '.$id
            );
        }

        $em->remove($file);
        $em->flush();
    } // "delete_user_comment"  [DELETE] /users/{username}/comments/{id}

    public function putUserFileAction($username, $id)
    {
        $em = $this->get('doctrine')->getManager();
        $user = $em->getRepository('CaribooCNUserBundle:User')->loadUserByUsername($username);
        $files = $em->getRepository('CaribooCNFileBundle:File')->findByProfile($user->getProfile());
        $targetFile = $em->getRepository('CaribooCNFileBundle:File')->find($id);

        foreach ($files as $file) {
            $file->setProfilePicture(false);
        }

        $request = $this->getRequest(); 
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $file = $serializer->deserialize($request->getContent(), 'Cariboo\CNFileBundle\Entity\File', 'json');
        }

        $file->setProfile($user->getProfile());
        $targetFile = $em->merge($file);

        $em->persist($targetFile);

        $em->flush();

        $view = $this->view($file, 200)
            ->setTemplate('CaribooCNFileBundle:File:files.html.twig')
            ->setTemplateVar('file')
        ;

        return $this->handleView($view);

    } // "put_user"      [PUT] /users/{username}/files/{id}
}