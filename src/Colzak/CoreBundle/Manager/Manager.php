<?php

namespace Colzak\CoreBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class Manager
 * @package Colzak\CoreBundle\Doctrine\Manager
 */
abstract class Manager
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * @param DocumentManager $documentManager
     */
    public function setDocumentManager(DocumentManager $documentManager)
    {
        dump('mon manager est enfin la !!!');
        $this->documentManager = $documentManager;
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    /**
     * @param DocumentRepository $repository
     */
    public function setRepository(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }
}
