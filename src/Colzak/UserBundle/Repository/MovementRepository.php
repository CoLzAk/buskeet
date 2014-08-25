<?php

namespace Colzak\UserBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * MovementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovementRepository extends DocumentRepository
{
	public function getByFollowing($following) {
		$q = $this->createQueryBuilder();
		$arrayProfileId = array();
		foreach ($following as $profile) {
			$arrayProfileId[] = new \MongoId($profile->getId());
		}
		$q->field('profile.$id')->in($arrayProfileId);
		$q->sort('createdAt', 'desc');
		$q->limit(15);
		return $q->getQuery()->execute()->toArray(false);
	}

	public function getByEvent($eventId) {
		$q = $this->createQueryBuilder();
		$q->field('movementDetail.event.$id')->equals(new \MongoId($eventId));
		return $q->getQuery()->execute()->toArray(false);
	}

	public function getByPhoto($photoId) {
		$q = $this->createQueryBuilder();
		$q->field('movementDetail.photo.$id')->equals(new \MongoId($photoId));
		return $q->getQuery()->execute()->toArray(false);
	}

	public function getByProfile($profileId) {
		$q = $this->createQueryBuilder();
		$q->field('movementDetail.profile.$id')->equals(new \MongoId($profileId));
		return $q->getQuery()->execute()->toArray(false);
	}
}