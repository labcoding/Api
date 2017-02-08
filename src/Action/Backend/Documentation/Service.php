<?php

namespace LabCoding\Api\Action\Backend\Documentation;

use T4webDomainInterface\ServiceInterface;

class Service implements ServiceInterface
{

    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function handle($criteria, $changes)
    {
        $docs = file_get_contents($this->config['api']['docs']);

        if(!isset($this->config['api']['docs']) || empty($this->config['api']['docs'])) {
            $swagger = \Swagger\scan(getcwd() . '/module');
            return $swagger->__toString();
        }

        return $docs;
    }
}