<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-23 
 */

namespace Net\Bazzline\Component\ProcessForkManager\Example\WithReachingMemoryLimit;

use Net\Bazzline\Component\ProcessForkManager\AbstractTask;

/**
 * Class ExampleTask
 * @package Net\Bazzline\Component\ProcessForkManager\Example\WithReachingMemoryLimit
 */
class ExampleTask extends AbstractTask
{
    /**
     * @var int
     */
    private $numberOfDataMultiplication;

    /**
     * @return int
     */
    public function getNumberOfDataMultiplication()
    {
        return $this->numberOfDataMultiplication;
    }

    /**
     * @param int $number
     */
    public function setNumberOfDataMultiplication($number)
    {
        $this->numberOfDataMultiplication = $number;
    }

    /**
     * @throws \Net\Bazzline\Component\ProcessForkManager\RuntimeException
     */
    public function execute()
    {
        $identifier = 'task (' . posix_getpid() . ' / ' . $this->getParentProcessId() . ')';
        $workingDataSet = array();

        echo $identifier . ' says hello' . PHP_EOL;

        for ($iterator = 0; $iterator < $this->numberOfDataMultiplication; ++$iterator) {
            //begin creating one megabyte of data
            //taken from https://github.com/stevleibelt/examples/blob/master/php/array/createOneMegaByteOfData.php
            $anotherRound = true;
            $data = array();
            $initialMemoryUsage = memory_get_usage(true);
            $anotherIterator = 0;
            $memoryUsageInMegaByteToGenerate = 1;

            while ($anotherRound) {
                $data[] = $anotherIterator;
                $currentMemoryUsage = (memory_get_usage(true) - $initialMemoryUsage);
                $currentMemoryUsageInMegaBytes = ($currentMemoryUsage / (1024 * 1024));
                if ($currentMemoryUsageInMegaBytes === $memoryUsageInMegaByteToGenerate) {
                    $anotherRound = false;
                }
                ++$anotherIterator;
            }
            //end creating one megabyte of data
            $workingDataSet[] = $data;
            sleep(1);
        }

        echo $identifier . ' says goodbye' . PHP_EOL;
    }
}