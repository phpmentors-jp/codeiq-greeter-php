<?php

namespace CodeIQ\Greeter;

class GreeterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Greeter
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new Greeter;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\CodeIQ\Greeter\Greeter', $actual);
    }

    /**
     * @expectedException \CodeIQ\Greeter\Exception\LogicException
     */
    public function test_Exception()
    {
        throw new Exception\LogicException;
    }
}
