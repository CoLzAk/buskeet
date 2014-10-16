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
use Colzak\MediaBundle\Document\Video;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Colzak\UserBundle\Document\Movement;
use Colzak\UserBundle\Document\MovementDetail;

class VideosController extends BaseController {

    /**
     * GET Route annotation.
     * @Get("/users/{userId}/videos")
     */
    public function getUserVideosAction($userId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);

        $q = $dm->createQueryBuilder('ColzakMediaBundle:Video');
        $q->field('profile')->references($user->getProfile());
        $data = $q->getQuery()->execute();

        return $this->handleView($this->view($data, 200));
    } // "get_users_files"   [GET] /users/{userId}/files

    /**
     * POST Route annotation.
     * @Post("/users/{userId}/videos")
     */
    public function postUserVideosAction($userId)
    {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $profile = $user->getProfile();
        $request = $this->container->get('request');

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);

            // var_dump($data); die();

            $video = new Video();
            $video->setProfile($profile);
            $video->setUrl($data['url']);
            $video->setEmbeddedCode($this->youtubeEmbedFromUrl($data['url'], 300, 200));
            $video->setPlateform('youtube');

            $dm->persist($video);

            $movement = new Movement();
            $movement->setProfile($user->getProfile());
            $movementDetail = new MovementDetail();
            $movementDetail->setAction(MovementDetail::ACTION_ADDED_VIDEO);
            $movementDetail->setVideo($video);
            $movement->setMovementDetail($movementDetail);
            $dm->persist($movement);

            $dm->flush();
        }

        return $this->handleView($this->view($video, 200));
    } // "post_users_files"   [POST] /users/{id}/files

    /**
     * DELETE Route annotation.
     * @Delete("/users/{userId}/videos/{videoId}")
     */
    public function deleteUserPhotosAction($userId, $videoId) {
        $dm = $this->container->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('ColzakUserBundle:User')->find($userId);
        $video = $dm->getRepository('ColzakMediaBundle:Video')->find($videoId);

        $videos = $user->getProfile()->getVideos();
        $this->deleteRelatedVideos($videoId);

        $dm->remove($video);
        $dm->flush();
        return $this->handleView($this->view($videos, 200));
    }

    private function deleteRelatedVideos($videoId) {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $movements = $dm->getRepository('ColzakUserBundle:Movement')->getByVideo($videoId);

        foreach ($movements as $movement) {
            $dm->remove($movement);
        }
    }

    /**
     * http://webdeveloperswall.com/php/generate-youtube-embed-code-from-url
    **/
    protected function youtubeEmbedFromUrl($youtube_url, $width, $height) {
        $vid_id = $this->extractUTubeVidId($youtube_url);
        if (strlen($vid_id) === 0) {
            die();
            
        }
        return $this->generateYoutubeEmbedCode($vid_id, $width, $height);
    }
     
    protected function extractUTubeVidId($url) {
        /*
        * type1: http://www.youtube.com/watch?v=H1ImndT0fC8
        * type2: http://www.youtube.com/watch?v=4nrxbHyJp9k&feature=related
        * type3: http://youtu.be/H1ImndT0fC8
        */
        $vid_id = "";
        $flag = false;
        if(isset($url) && !empty($url)){
            /*case1 and 2*/
            $parts = explode("?", $url);
            if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){
                $params = explode("&", $parts[1]);
                if(isset($params) && !empty($params) && is_array($params)){
                    foreach($params as $param){
                        $kv = explode("=", $param);
                        if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){
                            if($kv[0]=='v'){
                                $vid_id = $kv[1];
                                $flag = true;
                                break;
                            }
                        }
                    }
                }
            }
            
            /*case 3*/
            if(!$flag){
                $needle = "youtu.be/";
                $pos = null;
                $pos = strpos($url, $needle);
                if ($pos !== false) {
                    $start = $pos + strlen($needle);
                    $vid_id = substr($url, $start, 11);
                    $flag = true;
                }
            }
        }
        return $vid_id;
    }
     
    protected function generateYoutubeEmbedCode($vid_id, $width, $height){
        $w = $width;
        $h = $height;
        $html = '<iframe width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$vid_id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
        return $html;
    }
}