<?php

namespace LabCoding\Api\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use LabCoding\Api\Domain\LogEntry\Service\Creator;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

class LogEntryListener extends AbstractListener implements ListenerAggregateInterface
{

    /**
     * @var Creator
     */
    protected $logEntryCreator;

    public function __construct($logEntryCreator)
    {
        $this->logEntryCreator = $logEntryCreator;
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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'writeLog'], 2);
    }

    /**
     * @param EventInterface $e
     */
    public function writeLog(EventInterface $e)
    {
        if (false === $this->canExecute($e)) {
            return;
        }

        $this->logEntryCreator->write();
    }
}