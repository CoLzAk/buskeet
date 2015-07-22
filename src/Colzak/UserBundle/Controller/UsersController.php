<?php

// src/Colzak/UserBundle/Controller/UsersController.php

namespace Colzak\UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController as BaseController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\UserBundle\Model\UserInterface;
use Colzak\UserBundle\Document\Movement;
use Colzak\UserBundle\Document\MovementDetail;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Colzak\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UsersController
 * @package Colzak\UserBundle\Controller
 *
 * @FOSRest\Prefix("/")
 * @FOSRest\NamePrefix("users_")
 */
class UsersController extends BaseController
{
    /**
     * @ApiDoc(
     *     section="Users",
     *     description="Get users list"
     * )
     * @FOSRest\View()
     * @FOSRest\Get("/users")
     */
    public function cgetUsersAction()
    {
        $em    = $this->get('doctrine_mongodb')->getManager();
        $users = $em->getRepository('ColzakUserBundle:User')->findAll();

        return $users;
    }

    /**
     * @ApiDoc(
     *     section="Users",
     *     description="Get user"
     * )
     * @FOSRest\View()
     * @FOSRest\Get("/users/{id}")
     */
    public function getUserAction($id)
    {
        // the target user
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($id);

        return $user;
    }

    /**
     * @ApiDoc(
     *     section="Users",
     *     description="Edit user"
     * )
     * @FOSRest\View()
     * @FOSRest\Put("/users/{id}")
     */
    public function putUserAction($id)
    {
        // the actual user
        $owner = $this->get('security.context')->getToken()->getUser();
        if (!is_object($owner) || !$owner instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $dm = $this->get('doctrine_mongodb')->getManager();

        $request = $this->getRequest();

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $updatedUser = $serializer->deserialize($request->getContent(), 'Colzak\UserBundle\Document\User', 'json');
        }
        $user = $dm->merge($updatedUser);
        $dm->flush();
        $user = $updatedUser;

        return $user;

    }

    /**
     * @ApiDoc(
     *     section="Users",
     *     description="Post user"
     * )
     * @FOSRest\View()
     * @FOSRest\Post("/users")
     */
    public function postUserAction(Request $request) {
        die('bonjour');
        var_dump($request);
        die();
        return [];
    }

    // PROFILE

    /**
     * GET Route annotation.
     * @Get("/users/profiles")
     */
    public function getProfilesAction()
    {
        $em    = $this->get('doctrine')->getManager();
        $data = $em->getRepository('ColzakUserBundle:Profile')->findAll();

        return $this->handleView($this->view($data, 200));
    } // "get_users"    [GET] /users/profiles

    /**
     * GET Route annotation.
     * @Get("/users/{userId}/profile")
     */
    public function getUserProfileAction($userId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $view = View::create();
        $view->setData($user->getProfile(), 200);
        $view->setFormat('json');
        return $view;
    }

    /**
     * GET Route annotation.
     * @Put("/users/{userId}/profile/{id}")
     */
    public function putUserProfileAction($id)
    {
        // the actual user
        $owner = $this->get('security.context')->getToken()->getUser();
        if (!is_object($owner) || !$owner instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $dm = $this->get('doctrine_mongodb')->getManager();
        // $user = $dm->getRepository('ColzakUserBundle:User')->find($id);

        $request = $this->getRequest();

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $request = $this->getRequest();
            $serializer = $this->get('jms_serializer');
            $updatedProfile = $serializer->deserialize($request->getContent(), 'Colzak\UserBundle\Document\Profile', 'json');
        }
        $profile = $dm->merge($updatedProfile);
        $dm->flush();
        $data = $updatedProfile;

        return $this->handleView($this->view($data, 200));

    } // "put_user"      [PUT] /users/{id}


    /**
     * GET Route annotation.
     * @Post("follow/users/{profileId}")
     */
    public function followUserAction($profileId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $follower = $user->getProfile();
        $followerId = $user->getProfile()->getId();
        $following = $dm->getRepository('ColzakUserBundle:Profile')->find($profileId);
        $follower->addFollowing($following);
        $following->addFollower($follower);

        $follower->setDistance(0);
        $following->setDistance(0);
        $dm->persist($follower);
        $dm->persist($following);

        //add movement
        $movement = new Movement();
        $movement->setProfile($follower);
        $movementDetail = new MovementDetail();
        $movementDetail->setAction(MovementDetail::ACTION_FOLLOWED_USER);
        $movementDetail->setProfile($following);
        $movementDetail->setProfile($following);
        $movement->setMovementDetail($movementDetail);
        $dm->persist($movement);
        $dm->flush();

        return $this->handleView($this->view($following, 200));
    }

    /**
     * GET Route annotation.
     * @Delete("/unfollow/users/{profileId}")
     */
    public function unfollowUserAction($profileId) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $follower = $user->getProfile();
        $followerId = $user->getProfile()->getId();
        $following = $dm->getRepository('ColzakUserBundle:Profile')->find($profileId);

        $follower->removeFollowing($following);
        $following->removeFollower($follower);

        $follower->setDistance(0);
        $following->setDistance(0);
        $dm->persist($following);
        $dm->persist($follower);
        $dm->flush();

        return $this->handleView($this->view($following, 200));
    }

    /**
     * GET Route annotation.
     * @Get("/feeds")
     */
    public function getFeedsAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $following = $user->getProfile()->getFollowing();
        $data = array();

        if (count($following) > 0) {
            $data = $dm->getRepository('ColzakUserBundle:Movement')->getByFollowing($following);
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data,
            $this->get('request')->query->get('page', 1)/*page number*/,
            15 //number of elements per page
        );

        return $this->handleView($this->view($pagination, 200));
    }

    /**
     * GET Route annotation.
     * @Get("/feeds/profiles")
     */
    public function getFeedsProfilesAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $filter['lat'] = $user->getProfile()->getCoordinates()->getY();
        $filter['lng'] = $user->getProfile()->getCoordinates()->getX();

        $profiles = $dm->getRepository('ColzakUserBundle:Profile')->profileFilteredSearch($filter);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $profiles,
            $this->get('request')->query->get('page', 1)/*page number*/,
            4 //number of elements per page
        );

        return $this->handleView($this->view($pagination, 200));
    }

    /**
     * GET Route annotation.
     * @Get("/feeds/events")
     */
    public function getFeedsEventsAction() {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $filter['lat'] = $user->getProfile()->getCoordinates()->getY();
        $filter['lng'] = $user->getProfile()->getCoordinates()->getX();

        $events = $dm->getRepository('ColzakEventBundle:Event')->eventFilteredSearch($filter);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $events,
            $this->get('request')->query->get('page', 1)/*page number*/,
            4 //number of elements per page
        );

        return $this->handleView($this->view($pagination, 200));
    }
}
