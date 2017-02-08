<?php

namespace LabCoding\Api\ErrorModel;

use Sebaks\ZendMvcController\ErrorInterface;
use Zend\Stdlib\ResponseInterface;

class ApiError implements ErrorInterface
{

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var integer
     */
    protected $code;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function methodNotAllowed()
    {
        $this->response->setStatusCode(405);

        $this->type = 'error-not-allowed';
        $error = json_encode($this->getError());

        $this->response->setContent($error);

        return $this->response;
    }

    /**
     * @param $criteriaErrors
     * @return mixed
     */
    public function notFoundByRequestedCriteria($criteriaErrors)
    {
        $this->response->setStatusCode(404);
        $this->response->getHeaders()->addHeaderLine("Content-Type", "application/json");
        $this->response->setContent(json_encode($criteriaErrors));

        return $this->response;
    }

    /**
     * @return array
     */
    public function getError()
    {
        $error = [
            'code' => ($this->code) ? $this->code : $this->response->getStatusCode(),
            'type' => $this->type,
            'message' => ($this->message) ? $this->message : $this->response->getReasonPhrase(),
        ];

        return $error;
    }

    /**
     * @param $code
     * @param null $type
     * @param null $message
     */
    public function setError($code, $type = null, $message = null)
    {
        $this->type = $type;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @param $changesErrors
     * @return mixed
     */
    public function changesErrors($changesErrors) {}

}
