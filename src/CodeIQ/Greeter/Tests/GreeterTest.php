<?php

namespace CodeIQ\Greeter\Tests;

use CodeIQ\Greeter\Clock;
use CodeIQ\Greeter\Greeter;

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
     * @var Globe
     */
    private $globe;

    /**
     * @test
     */
    public function 最初の時間範囲にマッチ()
    {
        $time = new \DateTimeImmutable();

        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));

        $firstTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $firstTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->never())
            ->method('contains');

        $this->SUT->addTimeRangeAndGreeting($firstTimeRange, 'one');
        $this->SUT->addTimeRangeAndGreeting($secondTimeRange, 'two');

        $this->assertThat($this->SUT->greet(), $this->equalTo('one'));
    }

    /**
     * @test
     */
    public function ニつ目の時間範囲にマッチ()
    {
        $time = new \DateTimeImmutable();

        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));

        $firstTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $firstTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));

        $thirdTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $thirdTimeRange->expects($this->never())
            ->method('contains');

        $this->SUT->addTimeRangeAndGreeting($firstTimeRange, 'one');
        $this->SUT->addTimeRangeAndGreeting($secondTimeRange, 'two');
        $this->SUT->addTimeRangeAndGreeting($thirdTimeRange, 'three');

        $this->assertThat($this->SUT->greet(), $this->equalTo('two'));
    }

    /**
     * @test
     */
    public function 時間範囲にマッチしない()
    {
        $time = new \DateTimeImmutable();

        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));

        $firstTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $firstTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $this->SUT->addTimeRangeAndGreeting($firstTimeRange, 'one');
        $this->SUT->addTimeRangeAndGreeting($secondTimeRange, 'two');

        $this->assertThat($this->SUT->greet(), $this->equalTo(''));
    }

    protected function setUp()
    {
        $this->clock = $this->getMock('CodeIQ\Greeter\Clock');
        $this->globe = $this->getMock('CodeIQ\Greeter\Globe');
        $this->SUT   = new Greeter($this->clock, $this->globe);
    }
}
