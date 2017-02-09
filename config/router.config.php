<?php

namespace LabCoding\Api;

return [
    'routes' => [
        'admin-api-console' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/admin/api/console',
                'defaults' => [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                ],
            ],
        ],

        'admin-logentry-list' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/admin/api/log-entry/list',
                'defaults' => [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                    'criteriaValidator' => Action\Backend\LogEntryList\CriteriaValidator::class,
                    'service' => Action\Backend\LogEntryList\Service::class,
                ],
            ],
        ],

        'admin-api-doc' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/admin/api/doc',
                'defaults' => [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                ],
            ],
        ],

        'admin-api-doc-generator' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/admin/api/doc/generate',
                'defaults' => [
                    'controller' => 'sebaks-zend-mvc-api-controller',
                    'allowedMethods' => ['GET'],
                    'service' => Action\Backend\Documentation\Service::class,
                    'viewModel' => Action\Backend\Documentation\ResultJsonViewModel::class,
                ],
            ],
        ],
    ],
];
