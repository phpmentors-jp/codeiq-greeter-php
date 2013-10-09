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
     * @var MorningTimeRange
     */
    private $morningTimeRange;

    function __construct(Clock $clock, MorningTimeRange $morningTimeRange)
    {
        $this->clock = $clock;
        $this->morningTimeRange = $morningTimeRange;
    }

    public function greet()
    {
        $currentTime = $this->clock->getCurrentTime();
        if ($this->timeIsMorning($currentTime)
        ) {
            return 'おはようございます';
        }
    }

    /**
     * @param $currentTime
     * @return bool
     */
    private function timeIsMorning($currentTime)
    {
        return $currentTime >= new \DateTimeImmutable('05:00:00') &&
        $currentTime < new \DateTimeImmutable('12:00:00');
    }
}
