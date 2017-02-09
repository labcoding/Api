<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Console\Request as ConsoleRequest;
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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'route'], 10);
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
            if(!isset($route['type'])) {
                $route['type'] = 'Segment';
            }

            if(!isset($route['options']['defaults'])) {
                $route['options']['defaults'] = [];
            }
            $defaults = $route['options']['defaults'];

            $defaults['basePath'] = (isset($defaults['basePath'])) ? $defaults['basePath'] : $apiConfig['basePath'];
            if(strpos($defaults['basePath'], '/') === 0) {
                $defaults['basePath'] = mb_substr($defaults['basePath'], 1);
            }

            $defaults['v'] = (isset($defaults['v'])) ? $defaults['v'] : $apiConfig['version'];

            $path = $this->buildPath($defaults);
            if(isset($defaults['basePath'])) {
                unset($defaults['basePath']);
            }
            if(isset($defaults['v'])) {
                unset($defaults['v']);
            }

            $route['options']['route'] = $path . $route['options']['route'];

            $defaults['controller'] = (isset($defaults['controller'])) ? $defaults['controller'] : $apiConfig['routerOptions']['controller'];
            $defaults['viewModel'] = (isset($defaults['viewModel'])) ? $defaults['viewModel'] : $apiConfig['routerOptions']['viewModel'];
            $defaults['allowedMethods'] = (isset($defaults['allowedMethods'])) ? $defaults['allowedMethods'] : $apiConfig['routerOptions']['allowedMethods'];

            $route['options']['defaults'] = $defaults;

            $router->addRoute($routeName, $route);

            ApiService::$apiRoutes[$routeName] = $routeName;

//            if(isset($route['may_terminate']) && $route['may_terminate'] == true) {
//                ApiService::$apiRoutes[$routeName] = $stack->assemble([], ['name' => $routeName]);
//            }
//
//            if(isset($route['child_routes']) && !empty($route['child_routes'])) {
//                foreach($route['child_routes'] as $name => $childRoute) {
//                    $childRouteName = $routeName . '/' . $name;
//                    ApiService::$apiRoutes[$childRouteName] = $stack->assemble([], ['name' => $childRouteName]);
//                }
//            }
        }

        return;
    }

    /**
     * @param array $defaults
     * @return string
     */
    private function buildPath(array $defaults)
    {
        $params = [
            'basePath' => $defaults['basePath'],
            'v' => $defaults['v'],
        ];

        $path = '';
        foreach($params as $key => $param) {
            if($param != "") {
                $path .= '/' . $param;
            }
        }

        return $path;
    }
}