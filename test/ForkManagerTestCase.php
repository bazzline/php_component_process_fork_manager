<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2014-07-28
 */

namespace Test\Net\Bazzline\Component\ProcessForkManager;

use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Class ForkManagerTestCase
 * @package Test\Net\Bazzline\Component\ProcessForkManager
 */
class ForkManagerTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessForkManager\TaskManager
     */
    protected function getMockOfTaskManager()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessForkManager\TaskManager');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessForkManager\AbstractTask
     */
    protected function getMockOfAbstractTask()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessForkManager\AbstractTask');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager
     */
    protected function getMockOfMemoryLimitManager()
    {
        return Mockery::mock('Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\TimeLimitManager\TimeLimitManager
     */
    protected function getMockOfTimeLimitManager()
    {
        return Mockery::mock('Net\Bazzline\Component\TimeLimitManager\TimeLimitManager');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessForkManager\AbstractTask
     */
    protected function getPartialMockOfAbstractTask()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessForkManager\AbstractTask[execute]');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessForkManager\ForkManagerEvent
     */
    protected function getMockOfForkManagerEvent()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessForkManager\ForkManagerEvent');
    }

    /**
     * @return Mockery\MockInterface|\Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getMockOfEventDispatcher()
    {
        return Mockery::mock('Symfony\Component\EventDispatcher\EventDispatcher');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessForkManager\ForkManager
     */
    protected function getMockOfForkManager()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessForkManager\ForkManager');
    }
}