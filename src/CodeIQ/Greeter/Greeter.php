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

    function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function greet()
    {
        $currentTime = $this->clock->getCurrentTime();
        if ($currentTime >= new \DateTimeImmutable('05:00:00') &&
            $currentTime < new \DateTimeImmutable('12:00:00')
        ) {
            return 'おはようございます';
        }
    }
}
