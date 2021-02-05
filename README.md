# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

I still like the idea but there is currently no use case to develop it anymore.

# Fork Component for PHP

This free as in freedom component easy up process forking and observing in php.
It is using the [memory limit manager](https://github.com/bazzline/php_component_memory_limit_manager) as well as the [time limit manager](https://github.com/bazzline/php_component_time_limit_manager) and the [event dispatcher](https://github.com/symfony/EventDispatcher) component as robust base.

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_process_fork_manager.png?branch=master)](http://travis-ci.org/bazzline/php_component_process_fork_manager)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_process_fork_manager.svg)](https://packagist.org/packages/net_bazzline/php_component_process_fork_manager)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_process_fork_manager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_process_fork_manager/) | [![build status](https://scrutinizer-ci.com/g/bazzline/php_component_process_fork_manager/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_process_fork_manager/)

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/53e48c23e0a229172f000146/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53e48c23e0a229172f000146)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/php_component_process_fork_manager.svg)](https://packagist.org/packages/net_bazzline/php_component_process_fork_manager)

It is also available at [openhub.net](http://www.openhub.net/p/718154).

# Error Handling

##  mandatory php function "posix_getpid" is not available

* uncomment "extension=posix.so' in your php.ini

# Examples

If you are running on an unix system, you can use "watch 'ps auxf | grep php'" to validate that threads where started.

* [basic](https://github.com/bazzline/php_component_process_fork_manager/tree/master/example/Basic/run)
* [with logging by using event dispatcher](https://github.com/bazzline/php_component_process_fork_manager/tree/master/example/WithLoggingByUsingEventDispatcher/run)
* [with more tasks then open threads](https://github.com/bazzline/php_component_process_fork_manager/tree/master/example/WithMoreTasksThenOpenThreads/run)
* [with reaching memory limit](https://github.com/bazzline/php_component_process_fork_manager/tree/master/example/WithReachingMemoryLimit/run)
* [with reaching time limit](https://github.com/bazzline/php_component_process_fork_manager/tree/master/example/WithReachingTimeLimit/run)

# Install

## By Hand

    mkdir -p vendor/net_bazzline/php_component_process_fork_manager
    cd vendor/net_bazzline/php_component_process_fork_manager
    git clone https://github.com/bazzline/php_component_process_fork_manager

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_process_fork_manager)

    composer require net_bazzline/php_component_process_fork_manager:dev-master

# Usage

```php
$factory = \Net\Bazzline\Component\ProcessForkManager\ForkManagerFactory();
$manager = $factory->create();

/** @var \Net\Bazzline\Component\ProcessForkManager\TaskInterface $task */
$task = new \My\Task();

$manager->addTask($task);
$manager->execute();
```

# API

Thanks to [apigen](https://github.com/apigen/apigen), the api is available in the [document](https://github.com/bazzline/php_component_process_fork_manager/blob/master/document/index.html) section or [online](http://code.bazzline.net/).

## Terms

The ForkManager itself gets multiple tasks attached. While executing, the fork manager keeps track of the current number of threads (working tasks) and time or memory limit.
Depending on situation, the manager will shutdown itself. This can be reached by sending different posix signals (for example kill).

* ForkManager
    * gets tasks attached
    * uses sub processes to execute task
    * takes care that forking is available
    * implements posix signal handling
    * taking care of optional runtime limit
    * taking care of optional memory limit
    * taking care of maximal number of sub processes
    * provides method "setUpPOSIXSignalHandling" and "dispatchPOSIXSignal" to implement posix signal handling

* Thread
    * the stupid simple sub process that works on a well defined task
    * implements posix signal handling

* AbstractTask
    * implements the unique logic a sub process should execute
    * implements
        * getProcessId()
        * getParentProcessId()
        * getRuntime()
        * getMemoryUsage()
    * provides method "setUpPOSIXSignalHandling" and "dispatchPOSIXSignal" to implement posix signal handling

# Future Improvements

* implement usage of [pcntl_wifexited](http://de1.php.net/manual/en/function.pcntl-wifexited.php)
* evaluate if [proc_open](https://github.com/ncuesta/Clinner/blob/master/src/Clinner/Command/Command.php) is better
* evaluate if [pthreads](https://github.com/krakjoe/pthreads)
* add shared memory for intern process calls 
    * [ipc-0](https://github.com/pbergman/processes-fork/tree/master/src/PBergman/SystemV/IPC)
    * [ipc-1](https://github.com/pear/PHP_Fork/blob/master/Fork.php)
    * [fifo-0](https://github.com/kriswallsmith/spork/blob/master/src/Spork/Fifo.php)
    * [fifo-1](https://github.com/mitallast/php-fork/blob/master/src/Fork/Fork.php)
    * [fifo-2](https://github.com/kriswallsmith/spork/blob/master/src/Spork/ProcessManager.php)
    * [shm-0](https://github.com/johan-adriaans/PHP-Semaphore-Fork-test/blob/master/index.php)
    * [shm-1](http://phpsblog.agustinvillalba.com/))
* add load based maximum number of threads like [throttleing](https://github.com/kriswallsmith/spork/blob/master/tests/Spork/Test/Util/ThrottleIteratorTest.php)
* extend signal handling like [here](https://github.com/barracudanetworks/forkdaemon-php/blob/master/fork_daemon.php)
* TaskInterface could implement
    * getGroupId()
    * getUserId()
    * setGroupId($groupId)
    * setUserId($userId)
    * task identifier
* how to write unit tests for forking itself?
    * [option one](http://kpayne.me/2012/01/17/how-to-unit-test-fork/)
* there is a theoretical race condition problem and i have no idea how to solve this in php
    * the parent process (fork manager) has process id 123
    * a child process (task) gets process id 124
    * child gets the signal kill or finished its execution and the process id 124 is available again
    * between the usleep of the parent, a new system process gets spawned with the process id 124
    * how distinguish if the process with id 124 is the child or a new process?
* implement usage of php [coroutine](https://nikic.github.io/2012/12/22/Cooperative-multitasking-using-coroutines-in-PHP.html)

# History

* upcomming
* [1.1.0](https://github.com/bazzline/php_component_process_fork_manager/tree/1.1.0) - released at 28.02.2016
    * updated example section
        * mv run.php run
        * chmod +x run
    * moved to psr-4 autoloading
    * removed dead api and documentation section
    * updated dependencies
* [1.0.11](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.11) - released at 18.08.2016
    * updated development dependencies
* [1.0.10](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.10) - released at 07.03.2016
    * updated dependencies
* [1.0.9](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.9) - released at 18.12.2015
    * updated dependencies
* [1.0.8](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.8) - released at 11.12.2015
    * updated dependencies
* [1.0.7](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.7) - released at 18.11.2015
    * updated dependencies
* [1.0.6](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.6) - released at 28.08.2015
    * updated dependencies
* [1.0.5](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.5) - released at 11.07.2015
    * updated dependencies
* [1.0.4](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.4) - released at 04.07.2015
    * removed phpmd
    * updated dependencies
* [1.0.3](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.3) - released at 29.06.2015
    * updated dependencies
* [1.0.2](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.2) - released at 08.02.2015
    * removed dependency to apigen
* [1.0.1](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.1) - released at 31.08.2014
    * updated dependencies
* [1.0.0](https://github.com/bazzline/php_component_process_fork_manager/tree/1.0.0) - released at 05.08.2014
    * initial commit with examples, unit tests and api documentation

## Links

Following links to projects and pages to easy up stepping into process forking (in php).
Thanks to all the great projects and pages out there.

* [fork explained at wikipedia.org](https://en.wikipedia.org/wiki/Fork_(operating_system))
* [fork tutorial for linux](http://www.yolinux.com/TUTORIALS/ForkExecProcesses.html)
* [php process forking](http://www.electrictoolbox.com/article/php/process-forking/)
* [php forking tutorial](http://phpsblog.agustinvillalba.com/)
* [php forking example to speed up image resizing](http://oliversmith.io/technology/2011/10/07/speeding-up-php-using-process-forking-for-image-resizing/)
* [pcntl_fork manual](http://php.net/manual/en/function.pcntl-fork.php)
* [php-process-manager by dannymar](https://github.com/dannymar/php-process-manager)
* [php spork by gwilym](https://github.com/gwilym/php-spork)
* [php fork by mitallast](https://github.com/mitallast/php-fork)
* [workman by jimbosjsb](https://github.com/jimbojsb/workman)
* [PHP-Fork by robbmj](https://github.com/robbmj/PHP-Fork)
* [php-fork by mpierzchalski](https://github.com/mpierzchalski/php-fork)
* [php spork by kriswallsmith](https://github.com/kriswallsmith/spork)
* [PHP_Fork by pear](https://github.com/pear/PHP_Fork)
* [process-fork by pbergman](https://github.com/pbergman/processes-fork)
* [forki by kakawait](https://github.com/kakawait/forki)
* [php semaphore fork test by johan addriaans](https://github.com/johan-adriaans/PHP-Semaphore-Fork-test)
* [fork-helper by ducan3dc](https://github.com/duncan3dc/fork-helper)
* [php thread by mmarquez](https://github.com/mmarquez/php-thread)
* [forkdaemon php by baracudanetworks](https://github.com/barracudanetworks/forkdaemon-php)
* [power spawn by lordgnu](https://github.com/lordgnu/PowerSpawn)
* [phpdaemon by yutas](https://github.com/yutas/phpdaemon)
* [phpdaemon by Ocean Internet](https://github.com/OceanInternet/phpdaemon)
* [PHPDaemonizer](https://github.com/denismilovanov/PHPDaemonizer)
* [PHP piped process communications](https://github.com/manav148/PPPC)

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it. [Donate something](https://gratipay.com/~stevleibelt) if you love it :-].
