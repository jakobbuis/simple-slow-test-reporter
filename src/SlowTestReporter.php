<?php

namespace SSTR;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeTestHook;

class SlowTestReporter implements BeforeTestHook, AfterTestHook, AfterLastTestHook
{
    private $testTimes;

    private const THRESHOLD_SLOW = 500;

    public function __construct()
    {
        $this->testTimes = [];
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
            return $time >= (self::THRESHOLD_SLOW / 1000);
        });

        if (count($this->testTimes) === 0) {
            return;
        }

        // Sort in descending order of test time
        arsort($this->testTimes);

        // print slow test information
        echo "\x1b[33m"; // terminal yellow text
        echo PHP_EOL . PHP_EOL . 'Slow tests (> ' . self::THRESHOLD_SLOW . ' msec): ' . PHP_EOL;
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
