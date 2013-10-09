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
     * @test
     */
    public function 朝ならおはようございます()
    {
        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(new \DateTimeImmutable('08:00:00')));

        $this->assertThat($this->SUT->greet(), $this->equalTo('おはようございます'));
    }

    /**
     * @test
     */
    public function 朝でないならあいさつなし()
    {
        $this->clock->expects($this->once())
            ->method('getCurrentTime')
            ->will($this->returnValue(new \DateTimeImmutable('15:00:00')));

        $this->assertThat($this->SUT->greet(), $this->equalTo(''));
    }

    protected function setUp()
    {
        $this->clock = $this->getMock('CodeIQ\Greeter\Clock');
        $this->SUT   = new Greeter($this->clock);
    }
}
