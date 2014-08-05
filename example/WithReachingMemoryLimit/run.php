<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithReachingMemoryLimit;

require_once __DIR__ . '/../bootstrap.php';
require_once 'ExampleTask.php';

use Net\Bazzline\Component\ProcessForkManager\ForkManagerFactory;

$factory = new ForkManagerFactory();
$manager = $factory->create();

$taskOne = new ExampleTask();
$taskTwo = new ExampleTask();
$taskThree = new ExampleTask();

$taskOne->setNumberOfDataMultiplication(1);
$taskTwo->setNumberOfDataMultiplication(2);
$taskThree->setNumberOfDataMultiplication(3);

/**
 * @var array|ExampleTask[] $tasks
 */
$tasks = array(
    1 => $taskOne,
    2 => $taskTwo,
    3 => $taskThree
);

foreach ($tasks as $task) {
    $manager->addTask($task);
}

$manager->getMemoryLimitManager()->setBufferInMegaBytes(1);
$manager->getMemoryLimitManager()->setLimitInMegaBytes(12);
$manager->execute();

foreach ($tasks as $key => $task) {
    $status = ($task->isAborted()) ?
        'aborted' : (($task->isFinished()) ?
            'finished' : 'not finished');
    echo 'task ' . $key . ' with run time of ' . $task->getNumberOfDataMultiplication() . ' seconds has been ' . $status . PHP_EOL;
}
