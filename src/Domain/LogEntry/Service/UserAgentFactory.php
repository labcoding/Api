<?php

namespace LabCoding\Api\Domain\LogEntry\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jenssegers\Agent\Agent;

class UserAgentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Agent();
    }
}