<?php

namespace LabCoding\Api;

return [
    'api-router' => [
        'routes' => [
            'api-v1-users' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/api/v1/users',
                    'defaults' => [
                        'allowedMethods' => ['GET'],
                    ],
                ],
            ],
        ],
    ],
];
