<?php

namespace LabCoding\Api\Action\Backend\Documentation;

use T4webDomainInterface\ServiceInterface;

class Service implements ServiceInterface
{

    /**
     * @var array
     */
    protected $config;

    /**
     * Service constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param mixed $criteria
     * @param mixed $changes
     * @return string
     */
    public function handle($criteria, $changes)
    {

        $docs = $this->config['api']['docs'];
        if(is_file($docs)) {
            return file_get_contents($docs);
        }

        $path = (is_dir($docs)) ? $docs : getcwd() . '/module';
        $swagger = \Swagger\scan($path);

        return $swagger->__toString();
    }
}