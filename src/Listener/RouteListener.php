<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Console\Request as ConsoleRequest;
use StaticPages\Action\Frontend;
use Zend\Mvc\Router\Http\TreeRouteStack;
use LabCoding\Api\Service\ApiService;

class RouteListener extends AbstractListenerAggregate implements ListenerAggregateInterface
{

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'route'], 100);
    }

    /**
     * @param EventInterface $event
     */
    public function route(EventInterface $event)
    {

        /** @var Request $request */
        $request = $event->getRequest();

        if ($request instanceof ConsoleRequest) {
            return;
        }

        $serviceManager = $event->getApplication()->getServiceManager();

        /** @var TreeRouteStack $router */
        $router = $event->getRouter();

        $config = $serviceManager->get('Config');

        $apiConfig = $config['api'];

        foreach($config['api-router']['routes'] as $routeName => $route) {
            ApiService::$apiRoutes[$routeName] = $route['options']['route'];

            if(!isset($route['options']['defaults'])) {
                $route['options']['defaults'] = [];
            }

            $options = $route['options']['defaults'];
            $options['controller'] = (isset($options['controller'])) ? $options['controller'] : $apiConfig['routerOptions']['controller'];
            $options['viewModel'] = (isset($options['viewModel'])) ? $options['viewModel'] : $apiConfig['routerOptions']['viewModel'];

            $route['options']['defaults'] = $options;

            $router->addRoute($routeName, $route);
        }

        return;
    }
}