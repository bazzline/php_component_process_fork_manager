# Fork Component for PHP

This component easy up process forking and observing in php.

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_process_fork_manager.png?branch=master)](http://travis-ci.org/bazzline/php_component_process_fork_manager)


## Terms

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

## Additional Ideas

* an event listener can be used to easy up extending this component
* add shared memory for intern process calls ([ipc](https://github.com/pbergman/processes-fork/tree/master/src/PBergman/SystemV/IPC) / [fifo](https://github.com/kriswallsmith/spork/blob/master/src/Spork/Fifo.php), [shm](https://github.com/johan-adriaans/PHP-Semaphore-Fork-test/blob/master/index.php))
* add logging (by event event handler?)
* AbstractTask should implement
    * getGroupId()
    * getUserId()
    * setGroupId($groupId)
    * setUserId($userId)
    * task identifier

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

# Open Questions

* how to write unit tests for forking itself?
    * [option one](http://kpayne.me/2012/01/17/how-to-unit-test-fork/)
* there is a theoretical race condition problem and i have no idea how to solve this in php
    * the parent process (fork manager) has process id 123
    * a child process (task) gets process id 124
    * child gets the signal kill or finished its execution and the process id 124 is available again
    * between the usleep of the parent, a new system process gets spawned with the process id 124
    * how distinguish if the process with id 124 is the child or a new process?
