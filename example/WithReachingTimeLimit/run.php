<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithReachingTimeLimit;

require_once __DIR__ . '/../bootstrap.php';
require_once 'ExampleTask.php';

use Net\Bazzline\Component\ProcessForkManager\ForkManagerFactory;

$factory = new ForkManagerFactory();
$manager = $factory->create();
$maximumRunTimeInSeconds = 9;

$taskOne = new ExampleTask();
$taskTwo = new ExampleTask();
$taskThree = new ExampleTask();

$taskOne->setRunTime(($maximumRunTimeInSeconds - 3)); //there is an offset of 2 seconds
$taskTwo->setRunTime($maximumRunTimeInSeconds);
$taskThree->setRunTime(($maximumRunTimeInSeconds + 1));

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

$manager->getTimeLimitManager()->setBufferInSeconds(0);
$manager->getTimeLimitManager()->setLimitInSeconds($maximumRunTimeInSeconds);

$manager->execute();

foreach ($tasks as $key => $task) {
    $status = ($task->isAborted()) ?
        'aborted' : (($task->isFinished()) ?
            'finished' : 'not finished');
    echo 'task ' . $key . ' with run time of ' . $task->getRunTime() . ' seconds has been ' . $status . PHP_EOL;
}
