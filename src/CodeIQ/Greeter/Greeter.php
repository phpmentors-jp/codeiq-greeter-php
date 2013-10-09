<?php
/**
 * This file is part of the CodeIQ.Greeter
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * CodeIQ.Greeter
 *
 * @package CodeIQ.Greeter
 */
class Greeter
{
    /**
     * @var Clock
     */
    private $clock;
    /**
     * @var array
     */
    private $timeRangeAndGreetings;

    function __construct(Clock $clock)
    {
        $this->clock = $clock;
        $this->timeRangeAndGreetings = [];
    }

    public function addTimeRangeAndGreeting(TimeRange $timeRange, $greeting)
    {
        $this->timeRangeAndGreetings[] = ['range' => $timeRange, 'greeting' => $greeting];
    }

    public function greet()
    {
        $currentTime = $this->clock->getCurrentTime();
        foreach ($this->timeRangeAndGreetings as $timeRangeAndGreeting)
        {
            if ($timeRangeAndGreeting['range']->contains($currentTime))
            {
                return $timeRangeAndGreeting['greeting'];
            }
        }

        return '';
    }
}
