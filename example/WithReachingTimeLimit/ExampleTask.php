<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithReachingTimeLimit;

use Net\Bazzline\Component\ProcessForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\ProcessForkManager\Example\WithReachingTimeLimit
 */
class ExampleTask extends AbstractTask
{
    /**
     * @var int
     */
    private $runTime = 1;

    /**
     * @return int
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * @param int $runTime
     */
    public function setRunTime($runTime)
    {
        $this->runTime = $runTime;
    }

    /**
     * @throws \Net\Bazzline\Component\ProcessForkManager\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();

        echo $identifier . ' says hello' . PHP_EOL;
        sleep($this->runTime);
        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage: ' . (memory_get_usage(true)) . ' bytes' . PHP_EOL;
    }
}