<?php

namespace BDBStudios\BreakfastSerializer\Tests;

use BDBStudios\BreakfastSerializer\Serializable;
use BDBStudios\BreakfastSerializer\Serializer;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $instance;

    public function setUp()
    {
        $this->instance = \Mockery::mock('BDBStudios\BreakfastSerializer\Serializer');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof Serializer);
    }
}
