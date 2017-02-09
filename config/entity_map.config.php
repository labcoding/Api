<?php

namespace LabCoding\Api;

return [
    'LogEntry' => [
        'entityClass' => Domain\LogEntry\LogEntry::class,
        'table' => 'api_logs',
        'columnsAsAttributesMap' => [
            'id' => 'id',
            'platform' => 'platform',
            'resource' => 'resource',
            'request_method' => 'requestMethod',
            'request_headers' => 'requestHeaders',
            'request_body' => 'requestBody',
            'response_code' => 'responseCode',
            'response_body' => 'responseBody',
            'created_dt' => 'createdDt',
            'ip' => 'ip',
        ],
        'criteriaMap' => [
            'id' => 'id_equalTo',
        ],
    ],
];
