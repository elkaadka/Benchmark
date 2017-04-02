<?php

namespace Kanel\Benchmark;

use PHPUnit\Framework\TestCase;
use Kanel\Benchmark\Exception\BenchmarkException;

class BenchmarkTest extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testStart()
    {
        Benchmark::start();
        $this->assertTrue(is_array(Benchmark::getHistory()));
        $this->assertTrue(empty(Benchmark::getHistory()));
    }

    public function testStopFail()
    {
        $this->expectException(BenchmarkException::class);
        Benchmark::reset();
        Benchmark::stop();
    }

    public function testStop()
    {
        Benchmark::start();
        $data = Benchmark::stop();
        $this->assertTrue(isset($data['time']));
        $this->assertTrue(isset($data['memory']));

    }

    public function testStopWithLaps()
    {
        Benchmark::start();
        Benchmark::lap();
        Benchmark::lap();
        $data = Benchmark::stop(Benchmark::FROM_LAST_LAP);
        $this->assertTrue(isset($data['time']));
        $this->assertTrue(isset($data['memory']));
        $data = Benchmark::getHistory();
        $this->assertEquals(count($data), 3);
        $this->assertTrue(isset($data[0]['time']));
        $this->assertTrue(isset($data[0]['memory']));
        $this->assertTrue(isset($data[1]['time']));
        $this->assertTrue(isset($data[1]['memory']));
        $this->assertTrue(isset($data[2]['time']));
        $this->assertTrue(isset($data[2]['memory']));
    }

    public function testLapFail()
    {
        $this->expectException(BenchmarkException::class);
        Benchmark::reset();
        Benchmark::lap();
    }

    public function testLap()
    {
        Benchmark::start();
        $data = Benchmark::lap();
        $this->assertTrue(isset($data['time']));
        $this->assertTrue(isset($data['memory']));
        $data = Benchmark::lap();
        $this->assertTrue(isset($data['time']));
        $this->assertTrue(isset($data['memory']));
    }

    public function testGetHistory()
    {
        Benchmark::start();
        Benchmark::lap();
        Benchmark::lap();
        Benchmark::stop();
        $data = Benchmark::getHistory();
        $this->assertEquals(count($data), 3);
        $this->assertTrue(isset($data[0]['time']));
        $this->assertTrue(isset($data[0]['memory']));
        $this->assertTrue(isset($data[1]['time']));
        $this->assertTrue(isset($data[1]['memory']));
        $this->assertTrue(isset($data[2]['time']));
        $this->assertTrue(isset($data[2]['memory']));
    }

}