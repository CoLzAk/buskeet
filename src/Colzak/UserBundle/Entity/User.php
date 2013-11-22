<?php
// src/Colzak/UserBundle/Entity/User.php

namespace Colzak\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as SERIAL;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Colzak\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="clzk_user")
 * @ORM\HasLifecycleCallbacks
 * @SERIAL\ExclusionPolicy("none")
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @SERIAL\Type("integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Colzak\UserBundle\Entity\Profile", mappedBy="user", cascade={"all"})
     * @SERIAL\Type("Colzak\UserBundle\Entity\Profile")
     */
    protected $profile;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param \Colzak\UserBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\Colzak\UserBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return \Colzak\UserBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
}