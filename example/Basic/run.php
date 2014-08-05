<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\Basic;

require_once __DIR__ . '/../bootstrap.php';
require_once 'ExampleTask.php';

use Net\Bazzline\Component\ProcessForkManager\ForkManagerFactory;

$factory = new ForkManagerFactory();
$manager = $factory->create();
$totalNumberOfTasks = 7;

for ($iterator = 0; $iterator < $totalNumberOfTasks; ++$iterator) {
    $task = new ExampleTask();
    $manager->addTask($task);
}

$manager->getTimeLimitManager()->setBufferInSeconds(2);
$manager->getTimeLimitManager()->setLimitInSeconds(20);

$manager->getMemoryLimitManager()->setBufferInMegaBytes(2);
$manager->getMemoryLimitManager()->setLimitInMegaBytes(64);

$manager->execute();
