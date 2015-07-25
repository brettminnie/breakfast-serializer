<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

class ConstructorWithArgumentsClass
{
    /**
     * @var string
     */
    protected $someValue;

    public function __construct($value)
    {
        $this->someValue = $value;
    }

    /**
     * @param $name
     * @return mixed
     *
     * @codeCoverageIgnore
     */
    public function __get($name)
    {
        if (property_exists(get_class($this), $name)) {
            return $this->{$name};
        }
    }
}