<?php
/**
 * This file is part of the CodeIQ.Greeter package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace CodeIQ\Greeter;

/**
 * Class TimeRange
 *
 * @package CodeIQ\Greeter
 */
abstract class TimeRange
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     */
    protected $first;
    /**
     * @var \DateTimeImmutable
     */
    protected $second;

    public function __construct($id, \DateTimeImmutable $first, \DateTimeImmutable $second)
    {
        $this->first = $first;
        $this->second = $second;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    abstract public function contains(\DateTimeImmutable $target);
}
