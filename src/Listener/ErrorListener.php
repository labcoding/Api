<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\ListenerAggregateInterface;
use LabCoding\Api\ErrorModel\ApiError;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Http\Header\ContentType;
use Zend\Json\Json;

class ErrorListener extends AbstractListenerAggregate implements ListenerAggregateInterface
{

    /**
     * @var ApiError
     */
    protected $errorModel;

    /**
     * ErrorListener constructor.
     * @param ApiError $errorModel
     */
    public function __construct(ApiError $errorModel)
    {
        $this->errorModel = $errorModel;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'dispatchError']);
//        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'dispatchError']);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'onFatalError']);
    }

    /**
     * @param MvcEvent $e
     * @return bool|HttpResponse
     */
    public function dispatchError(MvcEvent $e)
    {

        /** @var Request $request */
        $request = $e->getRequest();

        /** @var ContentType $contentType */
        $contentType = $request->getHeader('Content-type');
        if($contentType->getMediaType() !== 'application/json') {
            return false;
        }

        $error = $e->getError();
        if (empty($error)) {
            return false;
        }

        /** @var HttpResponse $response */
        $response = $e->getResponse();
        if (!$response) {
            $response = new HttpResponse();
            $response->setStatusCode(500);
            $e->setResponse($response);
        }

        switch ($error) {
            case Application::ERROR_CONTROLLER_NOT_FOUND:
            case Application::ERROR_CONTROLLER_INVALID:
            case Application::ERROR_ROUTER_NO_MATCH:

                $response->setStatusCode(404);

                break;

            case Application::ERROR_EXCEPTION:
            default:
                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $response->setStatusCode(500);
                }

                break;
        }

        $this->errorModel->setType($error);
        $errorData = $this->errorModel->getError();

        $config = $e->getApplication()->getServiceManager()->get('Config');
        if(true == $config['view_manager']['display_exceptions'] && $e->getParam('exception') != null) {
            $exception = $e->getParam('exception');

            $errorData['exception'] = [
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
            ];
        }

        $response->setContent(Json::encode($errorData));

        $e->stopPropagation(true);

        return $response;
    }

    /**
     * @param MvcEvent $e
     * @return bool
     */
    public function onFatalError(MvcEvent $e)
    {
        /** @var Request $request */
        $request = $e->getRequest();

        /** @var ContentType $contentType */
        $contentType = $request->getHeader('Content-type');
        if($contentType == null) {
            return false;
        }

        if($contentType->getMediaType() !== 'application/json') {
            return false;
        }

        ob_start();
        $errorHandler = new \Jasny\ErrorHandler();
        $errorHandler->logUncaught(E_ERROR);
        $errorHandler->onFatalError(function($exception) use($e) {
            $code = 500;

            $this->errorModel->setError($code, 'server-error', 'Internal Server Error');
            $error = $this->errorModel->getError();

            $config = $e->getApplication()->getServiceManager()->get('Config');
            if(true == $config['view_manager']['display_exceptions']) {
                $error['exception'] = [
                    'class' => get_class($exception),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'message' => $exception->getMessage(),
                ];
            }

            http_response_code($code);
            header('Content-Type: application/json');

            echo json_encode($error);

            return false;
        }, true);
    }
}