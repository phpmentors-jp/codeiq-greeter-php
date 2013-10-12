<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * Class Clock
 *
 * @package CodeIQ\Greeter
 */
class Clock
{
    /**
     * @return \DateTimeImmutable
     */
    public function getCurrentTime()
    {
        return new \DateTimeImmutable();
    }
}