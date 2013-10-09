<?php
namespace CodeIQ\Greeter;

class Clock
{
    /**
     * @return \DateTimeImmutable
     */
    public function getCurrentTime()
    {
        return new \DateTimeImmutable();
    }
}