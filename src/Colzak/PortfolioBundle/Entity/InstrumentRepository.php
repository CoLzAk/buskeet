<?php

namespace Colzak\PortfolioBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class InstrumentRepository extends EntityRepository
{
    public function loadInstrumentsBySlug($slug, $adjective) {
        $dql = ' SELECT i,t FROM ColzakPortfolioBundle:Instrument i JOIN i.instrumentType t ';
        if ($adjective) {
            $dql .= ' WHERE i.adjective LIKE :slug ';
        } else {
            $dql .= ' WHERE i.name LIKE :slug ';
        }
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('slug', $slug.'%')
            ->getArrayResult();
    }
}