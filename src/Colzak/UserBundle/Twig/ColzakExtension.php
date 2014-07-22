<?php

// src/Colzak/UserBundle/Twig/ColzakExtension.php
namespace Colzak\UserBundle\Twig;

class ColzakExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('age', array($this, 'ageFilter')),
            // new \Twig_SimpleFilter('sortedDisplay', array($this, 'photogalleryFilter')),
            // new \Twig_SimpleFilter('arraySearch', array($this, 'arraySearch')),
            // new \Twig_SimpleFilter('jsonDecode', array($this, 'jsonDecode')),
            // new \Twig_SimpleFilter('jsonEncode', array($this, 'jsonEncode')),
            // new \Twig_SimpleFilter('fullName', array($this, 'fullName')),
            // new \Twig_SimpleFilter('isOnline', array($this, 'isOnline')), 
        );
    }

    public function ageFilter($sDateBirth)
    {
        $oDateNow = new \DateTime();
        $oDateBirth = new \DateTime($sDateBirth);
        $oDateIntervall = $oDateNow->diff($oDateBirth);
        /* @var $oDateIntervall DateInterval */
        return $oDateIntervall->y;
    }

    // public function photogalleryFilter($files, $fileType = '')
    // {
    //     $output = array();
    //     foreach ($files as $file) {
    //         if ($file->getFileType() == $fileType)
    //         $output[] = $file;
    //     }
    //     // $oDateNow = new \DateTime();
    //     // $oDateBirth = new \DateTime($sDateBirth);
    //     // $oDateIntervall = $oDateNow->diff($oDateBirth);
    //     /* @var $oDateIntervall DateInterval */
    //     return $output;
    // }

    // public function jsonDecode($str) {
    //     return json_decode($str, true);
    // }

    // public function jsonEncode($str) {
    //     return json_encode($str);
    // }

    // public function fullName($name) {
    //     return $name[0].' '.substr($name[1], 0,1).'.';
    // }

    // public function isOnline($date) {
    //     return strtotime($date) > strtotime("-2 minutes");
    // }

    // public function arraySearch($haystack, $needle) {
    //     return (array_search($needle, $haystack) > -1);
    // }

    public function getName()
    {
        return 'colzak_extension';
    }
}