<?php

namespace Colzak\GeoBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicPlaceRepository extends DocumentRepository
{
    public function getByCoordinates($searchParams) {
    	// var_dump($searchParams);
        $q = $this->createQueryBuilder();
        $q->field('publicPlaceCoordinates')->geoNear((float)$searchParams['lat'], (float)$searchParams['lng'])->spherical(true)->distanceMultiplier(6378.137)->maxDistance(20/6371);
        $q->limit(10);
        return $q->getQuery()->execute()->toArray(false);;
    }
}