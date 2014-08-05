<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-31
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithLoggingByUsingEventDispatcher;

use Net\Bazzline\Component\ProcessForkManager\ForkManagerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Logger
 * @package Net\Bazzline\Component\ProcessForkManager\Example\WithLoggingByUsingEventDispatcher
 */
class LoggerEventSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     * The array keys are event names and the value can be:
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     * For instance:
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            ForkManagerEvent::FINISHED_EXECUTION => array('onFinishedExecution'),
            ForkManagerEvent::FINISHED_EXECUTION_OF_OPEN_TASK => array('onFinishedExecutionOfOpenTask'),
            ForkManagerEvent::FINISHED_TASK => array('onFinishedTask'),
            ForkManagerEvent::FINISHED_WAITING_FOR_RUNNING_TASKS => array('onFinishedWaitingForRunningTasks'),
            ForkManagerEvent::REACHING_MEMORY_LIMIT => array('onReachingMemoryLimit'),
            ForkManagerEvent::REACHING_TIME_LIMIT => array('onReachingTimeLimit'),
            ForkManagerEvent::STARTING_EXECUTION => array('onStartingExecution'),
            ForkManagerEvent::STARTING_EXECUTION_OF_OPEN_TASK => array('onStartingExecutionOfOpenTask'),
            ForkManagerEvent::STARTING_TASK => array('onStartingTask'),
            ForkManagerEvent::STARTING_WAITING_FOR_RUNNING_TASKS => array('onStartingWaitingForRunningTasks'),
            ForkManagerEvent::STOPPING_EXECUTION => array('onStoppingExecution'),
            ForkManagerEvent::STOPPING_TASK => array('onStoppingTask')
        );
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onFinishedExecution(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('finished execution', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onFinishedExecutionOfOpenTask(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('finished execution of open tasks', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onFinishedTask(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('finished task', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onFinishedWaitingForRunningTasks(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('finished waiting for running tasks', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onReachingMemoryLimit(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('reached memory limit', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onReachingTimeLimit(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('reached time limit', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStartingExecution(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('starting execution', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStartingExecutionOfOpenTask(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('starting execution of open tasks', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStartingTask(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('starting task', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStartingWaitingForRunningTasks(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('starting waiting for running tasks', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStoppingTask(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('stopping task', $event);
    }

    /**
     * @param ForkManagerEvent $event
     */
    public function onStoppingExecution(ForkManagerEvent $event)
    {
        $this->dumpingEventWithMessage('stopping execution', $event);
    }

    /**
     * @param string $message
     * @param ForkManagerEvent $event
     */
    private function dumpingEventWithMessage($message, ForkManagerEvent $event)
    {
        echo '----------------' . PHP_EOL;
        echo '  ' . $message . PHP_EOL;
        echo '  event:' . PHP_EOL;
        echo '    ' . ($event->hasForkManager() ? 'has fork manager' : 'has no fork manager') . PHP_EOL;
        echo '    ' . ($event->hasTask() ? 'has task' : 'has no task') . PHP_EOL;
        echo '    ' . ($event->hasSource() ? 'has source' : 'has no source') . PHP_EOL;
        if ($event->hasSource()) {
            echo '        source: ' . $event->getSource() . PHP_EOL;
        }
    }
}