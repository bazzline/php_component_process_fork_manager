<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-28
 */

namespace Test\Net\Bazzline\Component\ProcessForkManager;

use Net\Bazzline\Component\ProcessForkManager\TaskManager;

/**
 * Class TaskManagerTest
 * @package Test\Net\Bazzline\Component\ProcessForkManager
 */
class TaskManagerTest extends ForkManagerTestCase
{
    public function testOpenTasks()
    {
        $manager = $this->getNewTaskManager();
        $task = $this->getMockOfAbstractTask();

        //no tasks available
        $this->assertFalse($manager->areThereOpenTasksLeft());

        //add a task as open
        $manager->addOpenTask($task);
        $this->assertTrue($manager->areThereOpenTasksLeft());

        //fetch available open task
        $this->assertEquals($task, $manager->getOpenTask());

        //try to fetch available open task
        $this->assertFalse($manager->areThereOpenTasksLeft());
        $this->assertNull($manager->getOpenTask());
    }

    public function testMarkOpenTaskAsRunning()
    {
        $manager = $this->getNewTaskManager();
        $task = $this->getMockOfAbstractTask();

        $task->shouldReceive('markAsRunning')
            ->once();

        //get task as running
        $manager->addOpenTask($task);
        $manager->getOpenTask();
        $manager->markOpenTaskAsRunning($task);
    }

    public function testMarkRunningTaskAsAborted()
    {
        $manager = $this->getNewTaskManager();
        $task = $this->getMockOfAbstractTask();

        $task->shouldReceive('markAsRunning')
            ->once();
        $task->shouldReceive('markAsAborted')
            ->once();

        //get task as running
        $manager->addOpenTask($task);
        $manager->getOpenTask();
        $manager->markOpenTaskAsRunning($task);

        $manager->markRunningTaskAsAborted($task);
    }

    public function testMarkRunningTaskAsFinished()
    {
        $manager = $this->getNewTaskManager();
        $task = $this->getMockOfAbstractTask();

        $task->shouldReceive('markAsRunning')
            ->once();
        $task->shouldReceive('markAsFinished')
            ->once();

        //get task as running
        $manager->addOpenTask($task);
        $manager->getOpenTask();
        $manager->markOpenTaskAsRunning($task);

        $manager->markRunningTaskAsFinished($task);
    }

    /**
     * @return TaskManager
     */
    private function getNewTaskManager()
    {
        return new TaskManager();
    }
} 
