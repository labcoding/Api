<?php

namespace LabCoding\Api\Domain\LogEntry;

use T4webDomain\Entity;
use Zend\Http\Response;

class LogEntry extends Entity
{

    /**
     * @var array
     */
    public static $allowedMethods = [
        'GET',
        'POST',
    ];

    /**
     * @var array
     */
    public static $responseCodes = [
        Response::STATUS_CODE_200 => '200 OK',
        Response::STATUS_CODE_400 => '400 Bad Request',
        Response::STATUS_CODE_401 => '401 Unauthorized',
        Response::STATUS_CODE_404 => '404 Not Found',
        Response::STATUS_CODE_405 => '405 Method Not Allowed',
        Response::STATUS_CODE_500 => '500 Internal Server Error',
        Response::STATUS_CODE_502 => '502 Bad Gateway',
    ];

    /**
     * @var string
     */
    protected $platform;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $requestHeaders;

    /**
     * @var string
     */
    protected $requestBody;

    /**
     * @var string
     */
    protected $responseCode;

    /**
     * @var string
     */
    protected $responseBody;

    /**
     * @var string
     */
    protected $createdDt;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @param array $array
     * @return void
     */
    public function populate(array $array = [])
    {
        if ($this->id === null && empty($array['id'])) {
            if (empty($array['createdDt'])) {
                $array['createdDt'] = date('Y-m-d H:i:s');
            }
        }

        if(isset($array['requestHeaders']) && is_array($array['requestHeaders'])) {
            $array['requestHeaders'] = json_encode($array['requestHeaders']);
        }

        parent::populate($array);
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @return array
     */
    public function getRequestHeaders()
    {
        return json_decode($this->requestHeaders);
    }

    /**
     * @return string
     */
    public function getRequestBody()
    {
        return $this->requestBody;
    }

    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return string
     */
    public function getCreatedDt()
    {
        return $this->createdDt;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

}