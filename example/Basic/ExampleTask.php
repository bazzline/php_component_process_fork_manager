<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\Basic;

use Net\Bazzline\Component\ProcessForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\ProcessForkManager\Example
 */
class ExampleTask extends AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\ProcessForkManager\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $startTime = time();

        echo $identifier . ' says hello' . PHP_EOL;
        sleep(rand(3, 7));
        echo $identifier . ' says goodbye' . PHP_EOL;
        echo $identifier . ' runtime: ' . (time() - $startTime) . ' seconds' . PHP_EOL;
        echo $identifier . ' memory usage: ' . (memory_get_usage(true)) . ' bytes' . PHP_EOL;
    }
}