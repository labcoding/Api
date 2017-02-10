<?php

namespace LabCoding\Api;

use LabCoding\Api\Domain\LogEntry\LogEntry;
use T4web\Admin\ViewModel;
use Zend\Http\Response;

return [
    'layouts' => [
        'api-layout' => [
            'template' => 'layout/api-doc',
            'children' => [
                'api-top-panel',
            ],
        ],
    ],

    'contents' => [
        'admin-api-console' => [
            'layout' => 'admin-layout',
            'template' => 'api/admin/console',
            'data' => [
                'static' => [
                    'title' => 'API. Console',
                    'icon' => 'terminal',
                    'allowedMethods' => LogEntry::$allowedMethods,
                    'defaultRoute' => '/api/v1/',
                ],
            ],
        ],

        'admin-api-doc' => [
            'layout' => 'api-layout',
            'template' => 'api/admin/documentation',
            'data' => [
                'static' => [
                    'title' => 'API. Documentation',
                    'icon' => 'terminal',
                ],
            ],
        ],

        'admin-logentry-list' => [
            'layout' => 'admin-layout',
            'template' => 'api/admin/log-entry-list',
            'data' => [
                'static' => [
                    'title' => 'API. Logs list',
                    'icon' => 'fa-bug',
                ],
            ],
            'children' => [
                'filter' => [
                    'extend' => 't4web-admin-filter',
                    'data' => [
                        'static' => [
                            'horizontal' => false,
                        ],
                    ],
                    'children' => [
                        'filter-id' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'id',
                                    'label' => 'ID',
                                ],
                                'fromParent' => [
                                    'id' => 'value',
                                ],
                            ],
                        ],
                        'filter-resource' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'resource_like',
                                    'label' => 'Resource (use “%” to match an arbitrary number of characters)',
                                ],
                                'fromParent' => [
                                    'resource_like' => 'value',
                                ]
                            ],
                        ],
                        'filter-method' => [
                            'template' => 't4web-admin/block/form-element-select',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'requestMethod_equalTo',
                                    'label' => 'Request method',
                                    'options' => ['' => 'All'] + LogEntry::$allowedMethods
                                ],
                                'fromParent' => [
                                    'requestMethod_equalTo' => 'value',
                                ],
                            ],
                        ],
                        'filter-platform' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'platform_like',
                                    'label' => 'Platform (use “%” to match an arbitrary number of characters)',
                                ],
                                'fromParent' => [
                                    'platform_like' => 'value',
                                ],
                            ],
                        ],
                        'filter-code' => [
                            'template' => 't4web-admin/block/form-element-select',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'responseCode_equalTo',
                                    'label' => 'Response code',
                                    'options' => [0 => 'All'] + LogEntry::$responseCodes
                                ],
                                'fromParent' => [
                                    'responseCode_equalTo' => 'value',
                                ],
                            ],
                        ],
                        'filter-ip' => [
                            'template' => 't4web-admin/block/form-element-text',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'ip_like',
                                    'label' => 'Ip (use “%” to match an arbitrary number of characters)',
                                ],
                                'fromParent' => [
                                    'ip_like' => 'value',
                                ],
                            ],
                        ],
                        'filter-date' => [
                            'template' => 't4web-admin/block/form-element-datetime-range',
                            'capture' => 'form-element',
                            'data' => [
                                'static' => [
                                    'name' => 'createdDt',
                                    'label' => 'Request date',
                                ],
                                'fromParent' => [
                                    'createdDt_lessThan' => 'lessThen',
                                    'createdDt_greaterThan' => 'greaterThen',
                                ]
                            ],
                        ],
                        'form-button-clear' => [
                            'data' => [
                                'static' => [
                                    'routeName' => 'admin-logentry-list',
                                ],
                            ],
                        ],
                    ],
                ],
                'table' => [
                    'template' => 't4web-admin/block/table',
                    'viewModel' => ViewModel\TableViewModel::class,
                    'children' => [
                        'table-head-row' => [
                            'template' => 't4web-admin/block/table-tr',
                            'data' => [
                                'fromParent' => 'rows',
                            ],
                            'children' => [
                                'table-th-id' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Id',
                                            'width' => '5%',
                                        ],
                                    ],
                                ],
                                'table-th-platform' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Platform',
                                            'width' => '10%',
                                        ],
                                    ],
                                ],
                                'table-th-resource' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Resource',
                                            'width' => '45%',
                                        ],
                                    ],
                                ],
                                'table-th-code' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Responce code',
                                            'width' => '10%',
                                        ],
                                    ],
                                ],
                                'table-th-date' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Date',
                                            'width' => '15%',
                                        ],
                                    ],
                                ],
                                'table-th-ip' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Ip',
                                            'width' => '10%',
                                        ],
                                    ],
                                ],
                                'table-th-actions' => [
                                    'template' => 't4web-admin/block/table-th',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'static' => [
                                            'value' => 'Details',
                                            'width' => '5%',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'table-body-row' => [
                            'viewModel' => ViewModel\TableRowViewModel::class,
                            'template' => 'api/admin/block/table-tr-collapse',
                            'data' => [
                                'fromParent' => 'row',
                            ],
                            'children' => [
                                'table-td-id' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['id' => 'value'],
                                    ],
                                ],
                                'table-td-platform' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['platform' => 'value'],
                                    ],
                                ],
                                'table-td-resource' => [
                                    'template' => 'api/admin/block/table-td-resource',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => [
                                            'requestMethod' => 'requestMethod',
                                            'resource' => 'value',
                                        ],
                                    ],
                                ],
                                'table-td-code' => [
                                    'template' => 't4web-admin/block/table-td-labeled',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['responseCode' => 'value'],
                                        'static' => [
                                            'colorValueMap' => [
                                                Response::STATUS_CODE_200 => 'success',
                                                Response::STATUS_CODE_400 => 'danger',
                                                Response::STATUS_CODE_401 => 'primary',
                                                Response::STATUS_CODE_404 => 'danger',
                                                Response::STATUS_CODE_405 => 'warning',
                                                Response::STATUS_CODE_500 => 'danger',
                                                Response::STATUS_CODE_502 => 'info',
                                            ],
                                            'textValueMap' => [
                                                Response::STATUS_CODE_200 => LogEntry::$responseCodes[Response::STATUS_CODE_200],
                                                Response::STATUS_CODE_400 => LogEntry::$responseCodes[Response::STATUS_CODE_400],
                                                Response::STATUS_CODE_401 => LogEntry::$responseCodes[Response::STATUS_CODE_401],
                                                Response::STATUS_CODE_404 => LogEntry::$responseCodes[Response::STATUS_CODE_404],
                                                Response::STATUS_CODE_405 => LogEntry::$responseCodes[Response::STATUS_CODE_405],
                                                Response::STATUS_CODE_500 => LogEntry::$responseCodes[Response::STATUS_CODE_500],
                                                Response::STATUS_CODE_502 => LogEntry::$responseCodes[Response::STATUS_CODE_502],
                                            ],
                                        ],
                                    ],
                                ],
                                'table-td-date' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['createdDt' => 'value'],
                                    ],
                                ],
                                'table-td-ip' => [
                                    'template' => 't4web-admin/block/table-td',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => ['ip' => 'value'],
                                    ],
                                ],
                                'table-td-buttons' => [
                                    'template' => 't4web-admin/block/table-td-buttons',
                                    'capture' => 'table-td',
                                    'data' => [
                                        'fromParent' => 'id',
                                    ],
                                    'children' => [
                                        'collapse-button' => [
                                            'template' => 't4web-admin/block/collapse-button',
                                            'capture' => 'button',
                                            'data' => [
                                                'static' => [
                                                    'size' => 'xs',
                                                    'color' => 'primary',
                                                    'text' => 'Show',
                                                ],
                                                'fromParent' => [
                                                    'id' => 'target'
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'table-tr-collapse' => [
                                    'template' => 'api/admin/block/table-tr-collapse',
                                    'capture' => 'table-tr-collapse',
                                    'data' => [
                                        'fromParent' => [
                                            'id' => 'target',
                                            'resource' => 'resource',
                                            'requestMethod' => 'requestMethod',
                                            'requestBody' => 'requestBody',
                                            'requestHeaders' => 'requestHeaders',
                                            'responseBody' => 'value',
                                        ],
                                        'static' => [
                                            'jsonPrettyPrint' => true,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'childrenDynamicLists' => [
                        'table-body-row' => 'rowsData',
                    ],
                    'data' => [
                        'static' => [
                        ],
                        'fromGlobal' => [
                            'result' => 'rowsData',
                        ],
                    ],
                ],
                'paginator' => [
                    'extend' => 't4web-admin-paginator',
                    'viewModel' => 'Api\LogEntry\ViewModel\PaginatorViewModel',
                ],
            ],
        ],
    ],

    'blocks' => [
        't4web-admin-sidebar-menu' => [
            'children' => [
                [
                    'extend' => 't4web-admin-sidebar-menu-item',
                    'capture' => 'item',
                    'data' => [
                        'static' => [
                            'label' => 'Api',
                            'icon' => 'fa-exchange',
                        ],
                    ],
                    'children' => [
                        [
                            'extend' => 't4web-admin-sidebar-treeview-menu-item',
                            'capture' => 'treeview-item',
                            'data' => [
                                'static' => [
                                    'label' => 'Console',
                                    'route' => 'admin-api-console',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'extend' => 't4web-admin-sidebar-treeview-menu-item',
                            'capture' => 'treeview-item',
                            'data' => [
                                'static' => [
                                    'label' => 'Logs',
                                    'route' => 'admin-logentry-list',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'extend' => 't4web-admin-sidebar-treeview-menu-item',
                            'capture' => 'treeview-item',
                            'data' => [
                                'static' => [
                                    'label' => 'Documentation',
                                    'route' => 'admin-api-doc',
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                ],
            ],
        ],

        'api-top-panel' => [
            'capture' => 'top-panel',
            'template' => 'api/block/top-panel',
        ],
    ],
];

