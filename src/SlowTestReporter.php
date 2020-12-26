<?php

namespace SSTR;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeTestHook;

class SlowTestReporter implements BeforeTestHook, AfterTestHook, AfterLastTestHook
{
    private $testTimes;
    private $threshold;

    public function __construct(int $threshold = 500)
    {
        $this->testTimes = [];
        $this->threshold = $threshold;
    }

    public function executeBeforeTest(string $test): void
    {
        $this->testTimes[$this->formatTestName($test)] = 0;
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->testTimes[$this->formatTestName($test)] = $time;
    }

    public function executeAfterLastTest(): void
    {
        // Filter to slow tests
        $this->testTimes = array_filter($this->testTimes, function ($time) {
            return $time >= ($this->threshold / 1000);
        });

        if (count($this->testTimes) === 0) {
            return;
        }

        // Sort in descending order of test time
        arsort($this->testTimes);

        // print slow test information
        echo "\x1b[33m"; // terminal yellow text
        echo PHP_EOL . PHP_EOL . 'Slow tests (> ' . $this->threshold . ' msec): ' . PHP_EOL;
        foreach ($this->testTimes as $test => $time) {
            echo '  * ' . round($time, 2) . ' ' . $test . PHP_EOL;
        }
        echo "\x1b[0m"; // reset terminal colours
    }

    private function formatTestName(string $name): string
    {
        return preg_replace('/.*\\\/', '', $name);
    }
}
