<?php

namespace LabCoding\Api\Domain\LogEntry\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Creator(
            $serviceLocator->get("Api\\LogEntry\\Service\\Data"),
            $serviceLocator->get("LogEntry\\Infrastructure\\Repository"),
            $serviceLocator->get("LogEntry\\EntityFactory")
        );
    }
}