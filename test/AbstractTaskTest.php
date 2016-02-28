<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-28
 */

namespace Test\Net\Bazzline\Component\ProcessForkManager;

/**
 * Class AbstractTaskTest
 * @package Test\Net\Bazzline\Component\ProcessForkManager
 */
class AbstractTaskTest extends ForkManagerTestCase
{
    public function testSetStartTimeAndGetRunTime()
    {
        $currentTimestamp = time();
        $task = $this->getPartialMockOfAbstractTask();

        $this->assertGreaterThanOrEqual($currentTimestamp, $task->getRunTime());

        $startTime = $currentTimestamp - 100;
        $expectedRunTime = $currentTimestamp - $startTime;
        $task->setStartTime($startTime);
        $this->assertGreaterThanOrEqual($expectedRunTime, $task->getRunTime());
    }

    public function testSimpleGetterAndSetter()
    {
        $task = $this->getPartialMockOfAbstractTask();

        $currentMemoryLimit = memory_get_usage(true);
        $this->assertGreaterThanOrEqual($currentMemoryLimit, $task->getMemoryUsage());

        $this->assertNull($task->getParentProcessId());
        $parentProcessId = __LINE__;
        $task->setParentProcessId($parentProcessId);
        $this->assertEquals($parentProcessId, $task->getParentProcessId());

        $processId = getmypid();
        $this->assertEquals($processId, $task->getProcessId());
    }

    public function testMarkingAndValidatingStatus()
    {
        $task = $this->getPartialMockOfAbstractTask();

        $this->assertFalse($task->isAborted());
        $this->assertFalse($task->isFinished());
        $this->assertTrue($task->isNotStarted());
        $this->assertFalse($task->isRunning());

        $task->markAsAborted();
        $this->assertTrue($task->isAborted());
        $this->assertFalse($task->isFinished());
        $this->assertFalse($task->isNotStarted());
        $this->assertFalse($task->isRunning());

        $task->markAsFinished();
        $this->assertFalse($task->isAborted());
        $this->assertTrue($task->isFinished());
        $this->assertFalse($task->isNotStarted());
        $this->assertFalse($task->isRunning());

        $task->markAsRunning();
        $this->assertFalse($task->isAborted());
        $this->assertFalse($task->isFinished());
        $this->assertFalse($task->isNotStarted());
        $this->assertTrue($task->isRunning());
    }
}