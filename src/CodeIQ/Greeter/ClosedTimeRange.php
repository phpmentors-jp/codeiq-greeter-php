<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * Class ClosedTimeRange
 *
 * @package CodeIQ\Greeter
 */
class ClosedTimeRange extends TimeRange
{
    /**
     * @param \DateTimeImmutable $target
     * @return bool
     */
    public function contains(\DateTimeImmutable $target)
    {
        return $this->first <= $target && $target < $this->second;
    }
}