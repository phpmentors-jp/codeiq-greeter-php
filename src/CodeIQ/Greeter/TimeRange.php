<?php
namespace CodeIQ\Greeter;

abstract class TimeRange
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     */
    private $first;
    /**
     * @var \DateTimeImmutable
     */
    private $second;

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
