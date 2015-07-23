<?php

namespace Colzak\CoreBundle\Service;

use Colzak\CoreBundle\Manager\Manager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class Service
{
    private $manager;

    private $container;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function getManager()
    {
        return $this->manager;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    // // // // //
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }
}
