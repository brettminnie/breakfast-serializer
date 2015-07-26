<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

/**
 * Class SimpleClass
 * @package BDBStudios\BreakfastSerializerTests\Fixtures
 */
class SimpleClass
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $uid;

    public function __construct()
    {
        $this->name = 'SimpleClass Instance';
        $this->uid = uniqid();
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
