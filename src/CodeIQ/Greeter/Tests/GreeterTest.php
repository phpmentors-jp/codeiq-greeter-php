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
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function 最初の時間範囲にマッチ($locale, $one, $two, $three)
    {
        $time = new \DateTimeImmutable();

        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));

        $this->globe->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue($locale));

        $firstTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $firstTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));

        $firstTimeRange->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('firstrange'));

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->never())
            ->method('contains');
        $secondTimeRange->expects($this->never())
            ->method('getId');

        $this->SUT->addTimeRange($firstTimeRange);
        $this->SUT->addTimeRange($secondTimeRange);
        $this->SUT->addGreeting($locale, 'firstrange', $one);
        $this->SUT->addGreeting($locale, 'secondrange', $two);
        $this->SUT->addGreeting($locale, 'thirdrange', $three);

        $this->assertThat($this->SUT->greet(), $this->equalTo($one));
    }

    /**
     * @test
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function ニつ目の時間範囲にマッチ($locale, $one, $two, $three)
    {
        $time = new \DateTimeImmutable();

        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));

        $this->globe->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue($locale));

        $firstTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $firstTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $firstTimeRange->expects($this->never())
            ->method('getId');

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));

        $secondTimeRange->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('secondrange'));

        $thirdTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $thirdTimeRange->expects($this->never())
            ->method('contains');
        $thirdTimeRange->expects($this->never())
            ->method('getId');

        $this->SUT->addTimeRange($firstTimeRange);
        $this->SUT->addTimeRange($secondTimeRange);
        $this->SUT->addTimeRange($thirdTimeRange);
        $this->SUT->addGreeting($locale, 'firstrange', $one);
        $this->SUT->addGreeting($locale, 'secondrange', $two);
        $this->SUT->addGreeting($locale, 'thirdrange', $three);

        $this->assertThat($this->SUT->greet(), $this->equalTo($two));
    }

    /**
     * @test
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function 時間範囲にマッチしない($locale, $one, $two, $three)
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

        $firstTimeRange->expects($this->never())
            ->method('getId');

        $secondTimeRange = $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
        $secondTimeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));

        $secondTimeRange->expects($this->never())
            ->method('getId');

        $this->SUT->addTimeRange($firstTimeRange);
        $this->SUT->addTimeRange($secondTimeRange);
        $this->SUT->addGreeting($locale, 'firstrange', $one);
        $this->SUT->addGreeting($locale, 'secondrange', $two);

        $this->assertThat($this->SUT->greet(), $this->equalTo(''));
    }

    public function ロケールごとのあいさつデータ()
    {
        return [
            ['ja', 'おはようございます', 'こんにちは', 'こんばんは'],
            ['en', 'Good Morning', 'Good afternoon', 'Good evening'],
        ];
    }

    protected function setUp()
    {
        $this->clock = $this->getMock('CodeIQ\Greeter\Clock');
        $this->globe = $this->getMock('CodeIQ\Greeter\Globe');
        $this->SUT   = new Greeter($this->clock, $this->globe);
    }
}
