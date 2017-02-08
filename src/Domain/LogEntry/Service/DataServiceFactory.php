<?php

namespace LabCoding\Api\Domain\LogEntry\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DataService(
            $serviceLocator->get('Request'),
            $serviceLocator->get('Response'),
            $serviceLocator->get('Api\LogEntry\Service\UserAgent')
        );
    }
}