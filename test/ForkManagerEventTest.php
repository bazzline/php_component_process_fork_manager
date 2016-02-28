<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-08-05 
 */

namespace Test\Net\Bazzline\Component\ProcessForkManager;

use Net\Bazzline\Component\ProcessForkManager\ForkManagerEvent;

/**
 * Class ForkManagerEventTest
 * @package Test\Net\Bazzline\Component\ProcessForkManager
 */
class ForkManagerEventTest extends ForkManagerTestCase
{
    public function testGetHasAndSetForkManager()
    {
        $event = $this->getNewEvent();
        $manager = $this->getMockOfForkManager();

        $this->assertFalse($event->hasForkManager());
        $this->assertNull($event->getForkManager());

        $event->setForkManager($manager);

        $this->assertTrue($event->hasForkManager());
        $this->assertEquals($manager, $event->getForkManager());
    }

    public function testGetHasAndSetSource()
    {
        $event = $this->getNewEvent();
        $source = __METHOD__;

        $this->assertFalse($event->hasSource());
        $this->assertNull($event->getSource());

        $event->setSource($source);

        $this->assertTrue($event->hasSource());
        $this->assertEquals($source, $event->getSource());
    }

    public function testGetHasAndSetTask()
    {
        $event = $this->getNewEvent();
        $task = $this->getMockOfAbstractTask();

        $this->assertFalse($event->hasTask());
        $this->assertNull($event->getTask());

        $event->setTask($task);

        $this->assertTrue($event->hasTask());
        $this->assertEquals($task, $event->getTask());
    }

    public function testClone()
    {
        $firstEvent = $this->getNewEvent();
        $firstEvent->setForkManager($this->getMockOfForkManager());
        $firstEvent->setSource(__METHOD__);
        $firstEvent->setTask($this->getMockOfAbstractTask());

        $this->assertTrue($firstEvent->hasForkManager());
        $this->assertTrue($firstEvent->hasSource());
        $this->assertTrue($firstEvent->hasTask());

        $secondEvent = clone $firstEvent;

        $this->assertNotEquals($firstEvent, $secondEvent);
        $this->assertFalse($secondEvent->hasForkManager());
        $this->assertFalse($secondEvent->hasSource());
        $this->assertFalse($secondEvent->hasTask());
    }

    /**
     * @return ForkManagerEvent
     */
    private function getNewEvent()
    {
        return new ForkManagerEvent();
    }
} 