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

    //Other stuff

    public function loadUsersList($slugParams) {
        $parameters = array(
            'blacklisted' => false,
            'profilePicture' => true,
            'fileType' => 'photogallery',
        );

        foreach ($slugParams as $key => $value) {
            if ($key == 'age') {
                $dates = $this->getAgeGroup($value);
                $parameters['date1'] = $dates['d1'];
                $parameters['date2'] = $dates['d2'];
            } else {
                $parameters[$key] = $value;
            }
        }

        // print($this->loadUsersListDQL($slugParams)->getSQL());

        return $this->loadUsersListDQL($slugParams)
            ->setParameters($parameters)
            ->getArrayResult();
    }

    public function getAgeGroup($group) {
        $d1 = new \DateTime('NOW');
        $d2 = new \DateTime('NOW');
        $dates = array();

        if ($group == 'young') {
            $d1->sub(new \DateInterval('P18Y'));
            $d2->sub(new \DateInterval('P25Y'));
        }
        if ($group == 'middle') {
            $d1->sub(new \DateInterval('P25Y'));
            $d2->sub(new \DateInterval('P40Y'));
        }
        if ($group == 'advanced') {
            $d1->sub(new \DateInterval('P40Y'));
            $d2->sub(new \DateInterval('P60Y'));
        }
        if ($group == 'senior') {
            $d1->sub(new \DateInterval('P60Y'));
            $d2->sub(new \DateInterval('P120Y'));
        }

        $dates['d1'] = $d1->format('Y-m-d');
        $dates['d2'] = $d2->format('Y-m-d');

        return $dates;
    }

    private function loadUsersListDQL($slugParams) {
        $dql = 'SELECT 
                    partial us.{id, usernameCanonical, emailCanonical, lastLogin, lastActivity, roles}, 
                    partial pr.{id, firstname, lastname, birthdate, addressZipcode, addressCity, addressCoordinates, type, verifiedIdentity, verifiedDiplomas},
                    partial po.{id, universe, experience},
                    partial fi.{id, thumbPath}
                FROM 
                    CaribooCNUserBundle:User us
                LEFT JOIN 
                    us.profile pr
                LEFT JOIN
                    pr.portfolios po
                LEFT JOIN
                    pr.files fi';

        $dql .= ' WHERE us.blacklisted = :blacklisted';
        $dql .= ' AND fi.profilePicture = :profilePicture';
        $dql .= ' AND fi.fileType = :fileType';
        $dql .= (isset($slugParams['gender']) ? ' AND pr.gender = :gender' : '');
        $dql .= (isset($slugParams['age']) ? ' AND pr.birthdate BETWEEN :date1 AND :date2' : '');
        $dql .= (isset($slugParams['language']) ? ' AND pr.motherTongue = :language' : '');
        $dql .= (isset($slugParams['acceptSickChildren']) ? ' AND po.acceptSickChildren = :acceptSickChildren' : '');
        $dql .= (isset($slugParams['acceptLastMinute']) ? ' AND po.acceptLastMinute = :acceptLastMinute' : '');
        $dql .= (isset($slugParams['comfortableWithAnimals']) ? ' AND pr.comfortableWithAnimals = :comfortableWithAnimals' : '');
        $dql .= (isset($slugParams['smoker']) ? ' AND pr.smoker = :smoker' : '');
        $dql .= (isset($slugParams['ownCar']) ? ' AND pr.ownCar = :ownCar' : '');
        $dql .= (isset($slugParams['drivingLicence']) ? ' AND pr.drivingLicence = :drivingLicence' : '');

        return $this->getEntityManager()
            ->createQuery($dql);
    }
}
