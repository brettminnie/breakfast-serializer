<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures\TypeHandlers;
use BDBStudios\BreakfastSerializer\Property\TypeHandler\IsDateTime;
use BDBStudios\BreakfastSerializer\Property\TypeHandler\DateTimeHandler;

class DateTimeType implements IsDateTime
{
    use DateTimeHandler;

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var string
     */
    protected $invalidString;

    public function __construct()
    {
        $this->dateTime = new \DateTime();
        $this->invalidString = $this->dateTime->format(\DateTime::COOKIE);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function __get($value)
    {
        if (property_exists($this, $value)) {
            return $this->{$value};
        }
    }
}
