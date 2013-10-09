<?php

namespace CodeIQ\Greeter\Tests;

use CodeIQ\Greeter\Clock;
use CodeIQ\Greeter\Greeter;
use CodeIQ\Greeter\MorningTimeRange;

class GreeterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Greeter
     */
    public $SUT;
    /**
     * @var Clock
     */
    private $clock;
    /**
     * @var MorningTimeRange
     */
    private $morningTimeRange;

    /**
     * @test
     */
    public function 朝ならおはようございます()
    {
        $time = new \DateTimeImmutable();
        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));
        $this->morningTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));

        $this->assertThat($this->SUT->greet(), $this->equalTo('おはようございます'));
    }

    /**
     * @test
     */
    public function 朝でないならあいさつなし()
    {
        $time = new \DateTimeImmutable();
        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));
        $this->morningTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $this->assertThat($this->SUT->greet(), $this->equalTo(''));
    }

    protected function setUp()
    {
        $this->clock            = $this->getMock('CodeIQ\Greeter\Clock');
        $this->morningTimeRange = $this->getMock('CodeIQ\Greeter\MorningTimeRange');
        $this->SUT              = new Greeter($this->clock, $this->morningTimeRange);
    }
}
