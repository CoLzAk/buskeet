<?php

namespace Colzak\FileBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class FileRepository extends EntityRepository
{
	public function getByProfileAndFileType($profileId) {
        return $this->getEntityManager()
            ->createQuery('SELECT f.name, f.path, f.profilePicture, f.thumbPath, f.fileType FROM ColzakFileBundle:File f
                            WHERE f.profile = :profileId')
            ->setParameters(array('profileId' => $profileId))
            ->getResult();
    }
}