<?php

namespace LabCoding\Api\Action\Console;

use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Db\Adapter\Adapter;

class InitController extends AbstractConsoleController
{
    /**
     * @var Adapter
     */
    private $dbAdapter;

    /**
     * @var array
     */
    private $config;

    /**
     * InitController constructor.
     * @param Adapter $dbAdapter
     * @param array $config
     */
    public function __construct(Adapter $dbAdapter, array $config)
    {
        $this->dbAdapter = $dbAdapter;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function runAction()
    {
        if (!isset($this->config['entity_map']['LogEntry']['table'])) {
            throw new \RuntimeException('entity_map config not found');
        }
        $table = $this->config['entity_map']['LogEntry']['table'];

        $query = "CREATE TABLE IF NOT EXISTS `$table` (
                   `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    `platform` VARCHAR(255),
                    `resource` VARCHAR(255) NOT NULL,
                    `request_method` VARCHAR(255) NOT NULL,
                    `request_body` TEXT,
                    `request_headers` TEXT,
                    `response_code` VARCHAR(255) NOT NULL,
                    `response_body` TEXT,
                    `created_dt` DATETIME,
                    `ip` VARCHAR(255) NOT NULL
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        try {
            $this->dbAdapter->query($query, Adapter::QUERY_MODE_EXECUTE);

            return "API module initialized successfully" . PHP_EOL;
        } catch (\Exception $e) {
            return
                $e->getMessage() . PHP_EOL .
                $e->getTraceAsString() . PHP_EOL;
        }
    }
}
