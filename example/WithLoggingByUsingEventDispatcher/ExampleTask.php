<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-31
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithLoggingByUsingEventDispatcher;

use Net\Bazzline\Component\ProcessForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\ProcessForkManager\Example\WithLoggingByUsingEventDispatcher
 */
class ExampleTask extends AbstractTask
{
    /**
     * @throws \Net\Bazzline\Component\ProcessForkManager\RuntimeException
     */
    public function execute()
    {
        sleep(rand(3, 7));
    }
}