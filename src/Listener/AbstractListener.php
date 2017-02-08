<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use LabCoding\Api\Service\ApiService;

abstract class AbstractListener extends AbstractListenerAggregate
{
    protected function canExecute(EventInterface $e)
    {

        /** @var RouteMatch $routeMatch */
        $routeMatch = $e->getRouteMatch();

        if (!$routeMatch) {
            return false;
        }

        $matchedRoute = $routeMatch->getMatchedRouteName();

        return (bool)(isset(ApiService::$apiRoutes[$matchedRoute]));
    }
}