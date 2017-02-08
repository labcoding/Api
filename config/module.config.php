<?php

namespace LabCoding\Api;

use LabCoding\Api\Domain\LogEntry\Service\CreatorFactory;
use LabCoding\Api\Domain\LogEntry\Service\DataServiceFactory;
use LabCoding\Api\Domain\LogEntry\Service\UserAgentFactory;
use LabCoding\Api\ErrorModel\ApiErrorFactory;
use LabCoding\Api\ViewModel\ResultJsonViewModel;
use LabCoding\Api\Listener;

return [

    'api' => [
        'docs' => dirname(__DIR__) . '/docs/petstore.yaml',

        // default route options
        'routerOptions' => [
            'controller' => 'sebaks-zend-mvc-api-controller',
            'viewModel' => ViewModel\ResultJsonViewModel::class,
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

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

];
