<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * Class OpenTimeRange
 *
 * @package CodeIQ\Greeter
 */
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