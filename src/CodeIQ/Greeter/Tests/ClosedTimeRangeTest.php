<?php

namespace CodeIQ\Greeter\Tests;

use CodeIQ\Greeter\ClosedTimeRange;

class ClosedTimeRangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider 時間帯テストデータ
     */
    public function 時間帯に含むかどうか($first, $second, $target, $expected)
    {
        $timeRange = new ClosedTimeRange('',
            new \DateTimeImmutable($first),
            new \DateTimeImmutable($second));

        $this->assertThat($timeRange->contains(new \DateTimeImmutable($target)),
            $this->equalTo($expected));
    }

    public function 時間帯テストデータ()
    {
        return [
            ['04:00:00', '10:00:00', '02:00:00', false],
            ['04:00:00', '10:00:00', '04:00:00', true],
            ['04:00:00', '10:00:00', '05:00:00', true],
            ['04:00:00', '10:00:00', '10:00:00', false],
            ['04:00:00', '10:00:00', '12:00:00', false],
        ];
    }
}
 