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
        return 'おはようございます';
    }
}
