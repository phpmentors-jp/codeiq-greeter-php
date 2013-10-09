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
    private $timeRanges;
    /**
     * @var array
     */
    private $greetings;
    /**
     * @var Globe
     */
    private $globe;

    function __construct(Clock $clock, Globe $globe)
    {
        $this->clock      = $clock;
        $this->globe      = $globe;
        $this->timeRanges = [];
        $this->greetings  = [];
    }

    public function addTimeRange(TimeRange $timeRange)
    {
        $this->timeRanges[] = $timeRange;
    }

    public function addGreeting($locale, $timeRangeId, $greeting)
    {
        $this->greetings[$locale][$timeRangeId] = $greeting;
    }

    public function greet()
    {
        $currentTime   = $this->clock->getCurrentTime();
        $timeRangeId = $this->decideTimeRange($currentTime);
        $currentLocale = $this->globe->getLocale();

        if (isset($this->greetings[$currentLocale][$timeRangeId])) {
            return $this->greetings[$currentLocale][$timeRangeId];
        }

        return '';
    }

    private function decideTimeRange($currentTime)
    {
        foreach ($this->timeRanges as $timeRange) {
            if ($timeRange->contains($currentTime)) {
                return $timeRange->getId();
            }
        }

        return null;
    }
}
