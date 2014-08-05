<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-24 
 */

namespace Net\Bazzline\Component\ProcessForkManager;

use Net\Bazzline\Component\MemoryLimitManager\MemoryLimitManager;
use Net\Bazzline\Component\TimeLimitManager\TimeLimitManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ForkManagerFactory
 * @package Net\Bazzline\Component\ProcessForkManager
 */
class ForkManagerFactory
{
    /**
     * @return ForkManager
     */
    public function create()
    {
        $event = new ForkManagerEvent();
        $eventDispatcher = new EventDispatcher();
        $memoryLimitManager = new MemoryLimitManager();
        $taskManager = new TaskManager();
        $timeLimitManager = new TimeLimitManager();

        //set default values for optional properties
        $memoryLimitManager->setLimitInMegaBytes(128);
        $memoryLimitManager->setBufferInMegaBytes(8);

        $timeLimitManager->setLimitInHours(1);
        $timeLimitManager->setBufferInMinutes(4);

        $manager = new ForkManager();

        $manager->injectEvent($event);
        $manager->injectEventDispatcher($eventDispatcher);
        $manager->injectMemoryLimitManager($memoryLimitManager);
        $manager->injectTimeLimitManager($timeLimitManager);
        $manager->injectTaskManager($taskManager);
        $manager->setMaximumNumberOfThreads(16);
        $manager->setNumberOfMicrosecondsToCheckThreadStatus(100000);   //1000000 microseconds = 1 second

        return $manager;
    }
} 