<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter\Tests;

use CodeIQ\Greeter\Clock;
use CodeIQ\Greeter\Greeter;
use CodeIQ\Greeter\TimeRange;

/**
 * Class GreeterTest
 *
 * @package CodeIQ\Greeter\Tests
 */
class GreeterTest extends \PHPUnit_Framework_TestCase
{
    const FIRSTRANGE  = 'firstrange';
    const SECONDRANGE = 'secondrange';
    const THIRDRANGE  = 'thirdrange';
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
     * @var \DateTimeImmutable
     */
    private $time;

    /**
     * @test
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function 最初の時間範囲にマッチ($locale, $greeting1, $greeting2, $greeting3)
    {
        前提: {
            $this->ロケールをセット($locale);

            $firstTimeRange  = $this->マッチする時間範囲(self::FIRSTRANGE);
            $secondTimeRange = $this->マッチングが行われない時間範囲();

            $this->Greeterを構成($locale, $greeting1, $greeting2, $greeting3,
                $firstTimeRange, $secondTimeRange);
        }

        $this->assertThat($this->SUT->greet(), $this->equalTo($greeting1),
            'マッチした時間範囲のあいさつが返ること');
    }

    /**
     * @test
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function ニつ目の時間範囲にマッチ($locale, $greeting1, $greeting2, $greeting3)
    {
        前提: {
            $this->ロケールをセット($locale);

            $firstTimeRange  = $this->マッチしない時間範囲();
            $secondTimeRange = $this->マッチする時間範囲(self::SECONDRANGE);
            $thirdTimeRange  = $this->マッチングが行われない時間範囲();

            $this->Greeterを構成($locale, $greeting1, $greeting2, $greeting3,
                $firstTimeRange, $secondTimeRange, $thirdTimeRange);
        }

        $this->assertThat($this->SUT->greet(), $this->equalTo($greeting2),
            'マッチした時間範囲のあいさつが返ること');
    }

    /**
     * @test
     * @dataProvider ロケールごとのあいさつデータ
     */
    public function 時間範囲にマッチしない($locale, $greeting1, $greeting2, $greeting3)
    {
        前提: {
            $firstTimeRange  = $this->マッチしない時間範囲();
            $secondTimeRange = $this->マッチしない時間範囲();

            $this->Greeterを構成($locale, $greeting1, $greeting2, $greeting3,
                $firstTimeRange, $secondTimeRange);
        }

        $this->assertThat($this->SUT->greet(), $this->equalTo(''),
            '空文字列が返ること');
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

        $this->time = new \DateTimeImmutable();
        $this->時計が返す値をセット($this->time);
    }

    /**
     * @param $time
     */
    private function 時計が返す値をセット($time)
    {
        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue($time));
    }

    /**
     * @param $locale
     */
    private function ロケールをセット($locale)
    {
        $this->globe->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue($locale));
    }

    /**
     * @param $id
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function マッチする時間範囲($id)
    {
        $timeRange = $this->時間範囲モック();
        $this->時間範囲が指定時間を含む($timeRange, $this->time);
        $this->時間範囲のIDをセット($timeRange, $id);

        return $timeRange;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function マッチングが行われない時間範囲()
    {
        $timeRange = $this->時間範囲モック();
        $this->時間範囲のマッチングが行われない($timeRange);

        return $timeRange;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function マッチしない時間範囲()
    {
        $timeRange = $this->時間範囲モック();
        $this->時間範囲が指定時間を含まない($timeRange, $this->time);
        $this->時間範囲のIDは取得されない($timeRange);

        return $timeRange;
    }

    /**
     * @param           $locale
     * @param           $one
     * @param           $two
     * @param           $three
     * @param TimeRange $firstTimeRange
     * @param TimeRange $secondTimeRange
     * @param TimeRange $thridTimeRange
     */
    private function Greeterを構成($locale, $one, $two, $three,
        TimeRange $firstTimeRange,
        TimeRange $secondTimeRange = null,
        TimeRange $thridTimeRange = null)
    {
        $this->SUT->addTimeRange($firstTimeRange);
        if ($secondTimeRange){
            $this->SUT->addTimeRange($secondTimeRange);
        }
        if ($thridTimeRange){
            $this->SUT->addTimeRange($thridTimeRange);
        }
        $this->SUT->addGreeting($locale, self::FIRSTRANGE,  $one);
        $this->SUT->addGreeting($locale, self::SECONDRANGE, $two);
        $this->SUT->addGreeting($locale, self::THIRDRANGE,  $three);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function 時間範囲モック()
    {
        return $this->getMock('CodeIQ\Greeter\TimeRange', array(), array(), '', false);
    }

    /**
     * @param $timeRange
     * @param $time
     */
    private function 時間範囲が指定時間を含む($timeRange, $time)
    {
        $timeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(true));
    }

    /**
     * @param $timeRange
     * @param $time
     */
    private function 時間範囲が指定時間を含まない($timeRange, $time)
    {
        $timeRange->expects($this->once())
            ->method('contains')
            ->with($this->equalTo($time))
            ->will($this->returnValue(false));
    }

    /**
     * @param $timeRange
     * @param $id
     */
    private function 時間範囲のIDをセット($timeRange, $id)
    {
        $timeRange->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id));
    }

    /**
     * @param $timeRange
     */
    private function 時間範囲のIDは取得されない($timeRange)
    {
        $timeRange->expects($this->never())
            ->method('getId');
    }

    /**
     * @param $timeRange
     */
    private function 時間範囲のマッチングが行われない($timeRange)
    {
        $timeRange->expects($this->never())
            ->method('contains');
        $timeRange->expects($this->never())
            ->method('getId');
    }
}
