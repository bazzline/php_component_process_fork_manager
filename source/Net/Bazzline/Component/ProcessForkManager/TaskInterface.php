<?php
/**
 * @author: sleibelt
 * @since: 7/30/14
 */

namespace Net\Bazzline\Component\ProcessForkManager;

/**
 * Interface TaskInterface
 *
 * @package Net\Bazzline\Component\ProcessForkManager
 */
interface TaskInterface extends ExecutableInterface
{
    /**
     * @return int
     */
    public function getMemoryUsage();

    /**
     * @return int
     */
    public function getParentProcessId();

    /**
     * @return int
     */
    public function getProcessId();

    /**
     * @return bool
     */
    public function isAborted();

    /**
     * @return bool
     */
    public function isFinished();

    /**
     * @return bool
     */
    public function isNotStarted();

    /**
     * @return bool
     */
    public function isRunning();

    public function markAsAborted();

    public function markAsFinished();

    public function markAsRunning();

    /**
     * @param int $parentProcessId
     */
    public function setParentProcessId($parentProcessId);

    /**
     * @param int $timestamp
     */
    public function setStartTime($timestamp);
}