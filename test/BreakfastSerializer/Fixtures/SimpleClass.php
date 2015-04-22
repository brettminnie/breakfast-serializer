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
}
