<?php

namespace LabCoding\Api\ErrorModel;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiErrorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ApiError(
            $serviceLocator->get('Response')
        );
    }
}
