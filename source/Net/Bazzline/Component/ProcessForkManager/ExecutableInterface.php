<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-20 
 */

namespace Net\Bazzline\Component\ProcessForkManager;

/**
 * Interface ExecutableInterface
 * @package Net\Bazzline\Component\ProcessForkManager
 */
interface ExecutableInterface
{
    /**
     * @throws RuntimeException
     */
    public function execute();
} 