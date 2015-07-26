<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

/**
 * Class SimpleContainer
 * @package BDBStudios\BreakfastSerializerTests\Fixtures
 */
class SimpleContainer
{

    /**
     * @var bool
     */
    private $exposeMe;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $simpleArray;

    /**
     * @var string
     */
    protected $uid;

    public function __construct()
    {
        $this->name = 'SimpleContainer Instance';

        $this->uid = uniqid();

        $this->exposeMe = true;

        $this->simpleArray = array();
        $this->simpleArray[] = new SimpleClass();
        $this->simpleArray[] = new SimpleClass();
    }
}

