<?php
namespace CodeIQ\Greeter;

class ClosedTimeRange extends TimeRange
{
    /**
     * @param \DateTimeImmutable $target
     * @return bool
     */
    public function contains(\DateTimeImmutable $target)
    {
        return true;
    }
}