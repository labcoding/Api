<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Http\Request as HttpRequest;
use LabCoding\Api\Service\ApiService;

abstract class AbstractListener extends AbstractListenerAggregate
{
    protected function canExecute(EventInterface $e)
    {

        /** @var RouteMatch $routeMatch */
        $routeMatch = $e->getRouteMatch();

        if (!$routeMatch || !($e->getRequest() instanceof HttpRequest)) {
            return false;
        }

        $matchedRoute = $routeMatch->getMatchedRouteName();

        // for child routes
        $explode = explode('/', $matchedRoute);

        return (bool)(isset(ApiService::$apiRoutes[$explode[0]]));
    }
}