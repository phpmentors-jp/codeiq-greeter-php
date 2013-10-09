<?php

namespace CodeIQ\Greeter;

class MorningTimeRange
{
    public function contains(\DateTimeImmutable $target)
    {
        return true;
    }
}