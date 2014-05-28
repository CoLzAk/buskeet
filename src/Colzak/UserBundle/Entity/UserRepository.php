<?php

namespace Colzak\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserProviderInterface
{

    /**
     * Function loadUserByUsername
     * 
     * Charge un compte utilisateur
     * 
     * @param string $username
     * @return Colzak\UserBundle\Entity\User
     */
    public function loadUserByUsername($usernameCanonical)
    {
        return $this->loadUserByUsernameDQL()
            ->setParameter('username', $usernameCanonical)
            ->getOneOrNullResult();
    }

    public function refreshUser(UserInterface $user) {
        return $this->find($user->getId());
    }
 
    public function supportsClass($class) {
        return $class === 'Colzak\UserBundle\Entity\User';
    }

    public function generateUniqueUsername($data) {
        if (!$data['username']) {
            if ( isset($data['first_name']) || isset($data['last_name']) ) {
                $basename = $this->removeAccents(strtolower($data['first_name'] . '.' . $data['last_name']));
            } else {
                $basename = $this->removeAccents(strtolower($data['profile']['firstname'] . '.' . $data['profile']['lastname']));
            }
            
        } else {
            $basename = $data['username'];
        }

        // Get a list of the similar usernames
        $dql = "SELECT u.username FROM ColzakUserBundle:User u";
        $dql .= " WHERE LOWER(u.username) LIKE :username";
        $results = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('username', $basename . '%')
            ->getResult();

        if (count($results) > 0)
        {
            // Increment an index until a unique username is found
            $idx = 2;
            foreach ($results as $result) {
                $parts = explode('-', $result['username']);
                if (count($parts) > 2 && $parts[2] >= $idx)
                {
                    $idx = $parts[2] + 1;
                }
            }
            $data['username'] = $basename . '.' . $idx;
        }
        else
        {
            $data['username'] = $basename;
        }

        return $data['username'];
    }

    public function removeAccents($str)
    { 
        $from = array(
            "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", 
            "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", 
            "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", 
            "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
        ); 
        $to = array(
            "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", 
            "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", 
            "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", 
            "O", "O", "U", "U", "U", "U", "C"
        );
        return str_replace($from, $to, $str); 
    }

    public function getUsersList() {
        return $this->getUsersListDQL()
            ->getArrayResult();
    }

    public function getLastUsers($limit = 6) {
        return $this->getLastUsersDQL($limit)
            ->getResult();
    }

    public function getUser($id) {
        return $this->getUserDQL()
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }


    /**
     * 
     * Implémentations
     * 
     */


    /**
     * Function loadUserByUsernameDQL
     * 
     * Retourne un compte utilisateur par son pseudo (case insensitive).
     * (Utilisée pour l'authentification)
     * 
     * @return Query
     */
    private function loadUserByUsernameDQL()
    {
        $dql = "SELECT 
                    partial u.{id, username, usernameCanonical, emailCanonical, lastLogin, roles}
                FROM 
                    ColzakUserBundle:User u";
        // $dql .= " WHERE u.activated = true";
        // $dql .= " AND (u.blacklisted = false OR u.whitelisted = true)";
        $dql .= " WHERE u.usernameCanonical = :username";

        return $this->getEntityManager()
            ->createQuery($dql);
    }

    private function getUsersListDQL() {
        $dql = 'SELECT 
                    partial us.{id, usernameCanonical, emailCanonical},
                    partial pr.{id, firstname, lastname, locality},
                    partial po.{id},
                    partial poi.{id, name},
                    partial fi.{id, thumbPath, profilePicture}
                FROM
                    ColzakUserBundle:User us
                LEFT JOIN
                    us.profile pr
                LEFT JOIN
                    pr.portfolio po
                LEFT JOIN
                    po.instruments poi
                LEFT JOIN
                    pr.files fi
                WHERE fi.profilePicture = TRUE
                ORDER BY us.id DESC
                ';
        return $this->getEntityManager()->createQuery($dql);
    }

    private function getLastUsersDQL($limit) {
        $dql = 'SELECT 
                    partial us.{id, usernameCanonical, emailCanonical},
                    partial pr.{id, firstname, lastname},
                    partial fi.{id, thumbPath}
                FROM
                    ColzakUserBundle:User us
                LEFT JOIN
                    us.profile pr
                LEFT JOIN
                    pr.files fi
                ORDER BY us.id DESC
                LIMIT 0,6
                ';
        return $this->getManager()->createQuery($dql);
    }

    private function getUserDQL()
    {
        $dql = "SELECT 
                    partial us.{id, username, usernameCanonical, emailCanonical, lastLogin},
                    partial pr.{id, lastname, firstname, }
                FROM 
                    ColzakUserBundle:User u";
        // $dql .= " WHERE u.activated = true";
        // $dql .= " AND (u.blacklisted = false OR u.whitelisted = true)";
        $dql .= " WHERE u.usernameCanonical = :username";

        return $this->getEntityManager()
            ->createQuery($dql);
    }
}
