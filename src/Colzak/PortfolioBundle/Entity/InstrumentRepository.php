<?php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class InstrumentRepository extends EntityRepository
{
    public function loadInstrumentsBySlug($slug) {
        return $this->getEntityManager()
            ->createQuery('SELECT i,t FROM ColzakPortfolioBundle:Instrument i
                            JOIN i.instrumentType t
                            WHERE i.name LIKE :slug')
            ->setParameter('slug', $slug.'%')
            ->getArrayResult();
    }
}