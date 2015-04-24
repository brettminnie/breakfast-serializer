<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;

class SerializerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Serializer */
    protected $instance;

    public function testCreateJsonSerializer()
    {
        $this->instance = SerializerFactory::getSerializer();

        $this->assertTrue($this->instance instanceof JSONSerializer);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage An unsupported serializer type was requested
     */
    public function testCreateUnsupportedSerializer()
    {
        //We have an instance already, we will re-use it so lets destroy it
        SerializerFactory::destroySerializer();
        
        $this->instance = SerializerFactory::getSerializer(-1);
    }
}
