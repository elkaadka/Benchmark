<?php

namespace Kanel\Benchmark;

use Kanel\Benchmark\Exception\BenchmarkException;
use Kanel\MemoryUsage\MemoryUsage;
use Kanel\Timer\Timer;

/**
 * Class Benchmark
 * @package Kanel\Benchmark
 */
class Benchmark
{
    const FROM_LAST_LAP = 'last_lap';
    protected static $data;

    /**
     * function that starts/restarts the trackers
     */
    public static function start()
    {
        self::reset();
        Timer::start();
        MemoryUsage::start();
    }

    /**
     * Functions that simulates a lap
     * returns the duration and the memory used between the time it started tracking and the time lap was called or between the two last laps
     * @param string $fromLastLap
     * @return array
     * @throws BenchmarkException
     */
    public static function lap(string $fromLastLap = ''): array
    {
        if (Timer::getStatus() !== Timer::STARTED) {
            throw new BenchmarkException('Benchmark is not started', 500);
        }

        $data = [
            'time'   => Timer::lap($fromLastLap),
            'memory' => MemoryUsage::lap($fromLastLap),
        ];

        self::$data[] = $data;

        return $data;
    }

    /**
     * Functions that stops the banchmark
     * returns the duration and the memory used between the time it started tracking and the time stop was called or between the stop and the last lap
     * @param string $fromLastLap
     * @return array
     * @throws BenchmarkException
     */
    public static function stop(string $fromLastLap = ''): array
    {
        if (Timer::getStatus() !== Timer::STARTED) {
            throw new BenchmarkException('Benchmark is not started', 500);
        }

        $data = [
            'time'   => Timer::stop($fromLastLap),
            'memory' => MemoryUsage::stop($fromLastLap),
        ];

        self::$data[] = $data;

        return $data;
    }

    /**
     * Resets everything
     */
    public static function reset()
    {
        self::$data = [];
        Timer::reset();
        MemoryUsage::reset();
    }

    /**
     * returns all the metrics calculated throughout the Timer life
     * @return array
     */
    public static function getHistory(): array
    {
        return self::$data;
    }
}