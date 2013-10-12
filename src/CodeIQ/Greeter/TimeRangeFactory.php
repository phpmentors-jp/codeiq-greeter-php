<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * Class TimeRangeFactory
 *
 * @package CodeIQ\Greeter
 */
class TimeRangeFactory
{
    /**
     * @param $id
     * @param $start
     * @param $end
     * @return ClosedTimeRange|OpenTimeRange
     */
    public function create($id, $start, $end)
    {
        $startTimeObj = new \DateTimeImmutable($start);
        $endTimeObj   = new \DateTimeImmutable($end);

        if ($startTimeObj < $endTimeObj) {
            return new ClosedTimeRange($id, $startTimeObj, $endTimeObj);
        } else {
            return new OpenTimeRange($id, $endTimeObj, $startTimeObj);
        }
    }
}