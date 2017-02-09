<?php

namespace LabCoding\Api;

use LabCoding\Api\Domain\LogEntry\Service\CreatorFactory;
use LabCoding\Api\Domain\LogEntry\Service\DataServiceFactory;
use LabCoding\Api\Domain\LogEntry\Service\UserAgentFactory;
use LabCoding\Api\ErrorModel\ApiErrorFactory;
use LabCoding\Api\ViewModel\ResultJsonViewModel;
use LabCoding\Api\Listener;

return [

    'entity_map' => require_once 'entity_map.config.php',
    'router' => require_once 'router.config.php',
    'sebaks-view' => require_once 'sebaks-view.config.php',
    'api-router' => require_once 'api-router.config.php',

    /**
     * default route schema: /basePath/v/path
     */
    'api' => [
        'version' => 'v1',
        'basePath' => '/api',

        'docs' => dirname(__DIR__) . '/examples/annotations',

        // default route options
        'routerOptions' => [
            'controller' => 'sebaks-zend-mvc-api-controller',
            'viewModel' => ViewModel\ResultJsonViewModel::class,
            'allowedMethods' => ['GET'],
        ],
    ],

    'listeners' => [
        Listener\LogEntryListener::class,
        Listener\ErrorListener::class,
        Listener\RouteListener::class,
    ],

    'service_manager' => [
        'invokables' => [
            ResultJsonViewModel::class => ResultJsonViewModel::class,
        ],
        'factories' => [
            Listener\LogEntryListener::class => Listener\LogEntryListenerFactory::class,
            Listener\ErrorListener::class => Listener\ErrorListenerFactory::class,
            'Api\LogEntry\Service\Data' => DataServiceFactory::class,
            'Api\LogEntry\Service\Creator' => CreatorFactory::class,
            'Api\LogEntry\Service\UserAgent' => UserAgentFactory::class,
            'sebaks-zend-mvc-api-error-factory' => ApiErrorFactory::class,
        ],
        'aliases' => [
            'Api\ErrorModel\ApiError' => 'sebaks-zend-mvc-api-error-factory'
        ],
    ],

    'controllers' => [
        'factories' => [
            Action\Console\InitController::class => Action\Console\InitControllerFactory::class,
        ],
    ],

    'console' => [
        'router' => [
            'routes' => [
                'feedback-init' => [
                    'options' => [
                        'route' => 'api init',
                        'defaults' => [
                            'controller' => Action\Console\InitController::class,
                            'action' => 'run'
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

];
