<?php

namespace CodeIQ\Greeter;

class MorningTimeRange
{
    public function contains(\DateTimeImmutable $target)
    {
        return $target >= new \DateTimeImmutable('05:00:00') &&
        $target < new \DateTimeImmutable('12:00:00');
    }
}