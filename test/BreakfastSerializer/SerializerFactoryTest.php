<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;

class SerializerFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    public function testCreateJsonSerializer()
    {
        $this->instance = SerializerFactory::getSerializer();

        $this->assertTrue($this->instance instanceof JSONSerializer);
    }
}
