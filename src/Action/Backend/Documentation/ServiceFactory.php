<?php

namespace LabCoding\Api\Action\Backend\Documentation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Service(
            $serviceLocator->get('Config')
        );
    }
}
