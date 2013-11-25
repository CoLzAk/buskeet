<?php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class PortfolioRepository extends EntityRepository
{
    public function getTargets() {
        return $this->getEntityManager()
            ->createQuery('SELECT p,t FROM ColzakPortfolioBundle:Portfolio p
                            JOIN t.targets t')
            ->getArrayResult();
    }
}