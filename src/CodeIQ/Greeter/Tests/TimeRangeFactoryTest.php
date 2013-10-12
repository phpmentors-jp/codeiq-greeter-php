<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter\Tests;

use CodeIQ\Greeter\TimeRangeFactory;

/**
 * Class TimeRangeFactoryTest
 *
 * @package CodeIQ\Greeter\Tests
 */
class TimeRangeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeRangeFactory
     */
    private $SUT;

    /**
     * @test
     * @dataProvider 時間帯テストデータ
     */
    public function 時間範囲に応じた時間範囲オブジェクトの生成($first, $second, $expectedClassPrefix)
    {
        $this->assertThat(
            $this->SUT->create('', $first, $second),
            $this->isInstanceOf('CodeIQ\Greeter\\' . $expectedClassPrefix . 'TimeRange')
        );
    }

    public function 時間帯テストデータ()
    {
        return [
            ['04:00:00', '10:00:00', 'Closed'],
            ['18:00:00', '05:00:00', 'Open'],
        ];
    }

    protected function setUp()
    {
        $this->SUT = new TimeRangeFactory();
    }
}
 