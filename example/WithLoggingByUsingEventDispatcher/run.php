<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-31
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithLoggingByUsingEventDispatcher;

require_once __DIR__ . '/../bootstrap.php';
require_once 'ExampleTask.php';
require_once 'LoggerEventSubscriber.php';

use Net\Bazzline\Component\ProcessForkManager\ForkManagerFactory;

$factory = new ForkManagerFactory();
$manager = $factory->create();
$subscriber = new LoggerEventSubscriber();

$manager->setMaximumNumberOfThreads(4);
$totalNumberOfTasks = 7;

for ($iterator = 0; $iterator < $totalNumberOfTasks; ++$iterator) {
    $task = new ExampleTask();
    $manager->addTask($task);
}

$manager->getEventDispatcher()->addSubscriber($subscriber);
$manager->execute();
