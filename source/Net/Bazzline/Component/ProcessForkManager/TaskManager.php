<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\ProcessForkManager;

/**
 * Class TaskManager
 * @package Net\Bazzline\Component\ProcessForkManager
 */
class TaskManager
{
    /**
     * @var array|AbstractTask[]
     */
    private $abortedTasks;

    /**
     * @var bool
     */
    private $areThereOpenTasksLeft;

    /**
     * @var array|AbstractTask[]
     */
    private $finishedTasks;

    /**
     * @var array|AbstractTask[]
     */
    private $openTasks;

    /**
     * @var array|AbstractTask[]
     */
    private $runningTasks;

    public function __construct()
    {
        $this->abortedTasks = array();
        $this->areThereOpenTasksLeft = false;
        $this->finishedTasks = array();
        $this->openTasks = array();
        $this->runningTasks = array();
    }

    /**
     * @return bool
     */
    public function areThereOpenTasksLeft()
    {
        return $this->areThereOpenTasksLeft;
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addOpenTask(AbstractTask $task)
    {
        $this->openTasks[] = $task;
        $this->areThereOpenTasksLeft = true;

        return $this;
    }

    /**
     * @return null|AbstractTask
     */
    public function getOpenTask()
    {
        $task = array_shift($this->openTasks);

        if (empty($this->openTasks)) {
            $this->areThereOpenTasksLeft = false;
        }

        return $task;
    }

    /**
     * @param AbstractTask $task
     * @throws RuntimeException
     */
    public function markRunningTaskAsAborted(AbstractTask $task)
    {
        $key = $this->getArrayIndexKey($task);

        if (!isset($this->runningTasks[$key])) {
            throw new RuntimeException(
                'provided task is not running'
            );
        }

        $this->abortedTasks[$key] = $this->runningTasks[$key];
        $this->abortedTasks[$key]->markAsAborted();
        unset($this->runningTasks[$key]);
    }

    /**
     * @param AbstractTask $task
     * @throws RuntimeException
     */
    public function markRunningTaskAsFinished(AbstractTask $task)
    {
        $key = $this->getArrayIndexKey($task);

        if (!isset($this->runningTasks[$key])) {
            throw new RuntimeException(
                'provided task is not running'
            );
        }

        $this->finishedTasks[$key] = $this->runningTasks[$key];
        $this->finishedTasks[$key]->markAsFinished();
        unset($this->runningTasks[$key]);
    }

    /**
     * @param AbstractTask $task
     * @throws InvalidArgumentException
     * @todo implement validation if task is not in open|finished|aborted|running array
     */
    public function markOpenTaskAsRunning(AbstractTask $task)
    {
        $key = $this->getArrayIndexKey($task);
        $task->markAsRunning();

        $this->runningTasks[$key] = $task;
    }

    /**
     * @param AbstractTask $task
     * @return string
     */
    private function getArrayIndexKey(AbstractTask $task)
    {
        return spl_object_hash($task);
    }
}