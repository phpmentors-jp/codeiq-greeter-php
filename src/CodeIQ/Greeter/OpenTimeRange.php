<?php
namespace CodeIQ\Greeter;

class OpenTimeRange extends TimeRange
{
    /**
     * @param \DateTimeImmutable $target
     * @return bool
     */
    public function contains(\DateTimeImmutable $target)
    {
        return $target < $this->first || $this->second <= $target;
    }
}