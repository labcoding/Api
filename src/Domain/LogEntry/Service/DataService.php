<?php

namespace LabCoding\Api\Domain\LogEntry\Service;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Jenssegers\Agent\Agent;

class DataService implements DataServiceInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Agent
     */
    private $agent;

    public function __construct(
        Request $request,
        Response $response,
        Agent $agent
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->agent = $agent;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [
            'platform' => $this->agent->platform(),
            'resource' => $this->request->getRequestUri(),
            'requestMethod' => $this->request->getMethod(),
            'requestHeaders' => json_encode($this->request->getHeaders()->toArray()),
            'requestBody' => $this->request->getContent(),
            'responseCode' => $this->response->getStatusCode(),
            'responseBody' => $this->response->getBody(),
            'ip' => $this->request->getServer('REMOTE_ADDR'),
        ];

        return $data;
    }
}