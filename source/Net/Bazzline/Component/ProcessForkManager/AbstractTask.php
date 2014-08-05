<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ProcessForkManager;

/**
 * Class AbstractTask
 * @package Net\Bazzline\Component\ProcessForkManager
 */
abstract class AbstractTask implements TaskInterface
{
    const STATUS_ABORTED = 2;
    const STATUS_FINISHED = 1;
    const STATUS_NOT_STARTED = 0;
    const STATUS_RUNNING = 3;

    /**
     * @var int
     */
    private $parentProcessId;

    /**
     * @var int
     */
    private $startTime = 0;

    /**
     * @var int
     */
    private $status = self::STATUS_NOT_STARTED;

    /**
     * @return int
     */
    public function getRunTime()
    {
        return (time() - $this->startTime);
    }

    /**
     * @return int
     */
    public function getMemoryUsage()
    {
        return memory_get_usage(true);
    }

    /**
     * @return int
     */
    public function getParentProcessId()
    {
        return $this->parentProcessId;
    }

    /**
     * @return int
     */
    public function getProcessId()
    {
        return getmypid();
    }

    /**
     * @return bool
     */
    public function isAborted()
    {
        return ($this->status === self::STATUS_ABORTED);
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return ($this->status === self::STATUS_FINISHED);
    }

    /**
     * @return bool
     */
    public function isNotStarted()
    {
        return ($this->status === self::STATUS_NOT_STARTED);
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return ($this->status === self::STATUS_RUNNING);
    }

    public function markAsAborted()
    {
        $this->status = self::STATUS_ABORTED;
    }

    public function markAsFinished()
    {
        $this->status = self::STATUS_FINISHED;
    }

    public function markAsRunning()
    {
        $this->status = self::STATUS_RUNNING;
    }

    /**
     * @param int $parentProcessId
     */
    public function setParentProcessId($parentProcessId)
    {
        $this->parentProcessId = (int) $parentProcessId;
    }

    /**
     * @param int $timestamp
     */
    public function setStartTime($timestamp)
    {
        $this->startTime = (int) $timestamp;
    }

    protected function dispatchSignal()
    {
        pcntl_signal_dispatch();
    }

    /**
     * @param $nameOfSignalHandlerMethod
     * @throws InvalidArgumentException
     */
    protected function setUpSignalHandling($nameOfSignalHandlerMethod)
    {
        if (!is_callable(array($this, $nameOfSignalHandlerMethod))) {
            throw new InvalidArgumentException(
                'provided method name "' . $nameOfSignalHandlerMethod . '" is not available'
            );
        }

        //pcntl_signal(SIGHUP,    array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGINT,    array($this, $nameOfSignalHandlerMethod));  //shell ctrl+c
        //pcntl_signal(SIGUSR1,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGUSR2,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGQUIT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGILL,    array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGABRT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGFPE,    array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGSEGV,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGPIPE,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGALRM,   array($this, $nameOfSignalHandlerMethod));
        pcntl_signal(SIGTERM,   array($this, $nameOfSignalHandlerMethod));  //kill <pid>
        //pcntl_signal(SIGCHLD,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGCONT,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTSTP,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTTIN,   array($this, $nameOfSignalHandlerMethod));
        //pcntl_signal(SIGTTOU,   array($this, $nameOfSignalHandlerMethod));
    }
}