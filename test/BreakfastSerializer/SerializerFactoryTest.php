<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;
use BDBStudios\BreakfastSerializerTest\Fixtures\SimpleClass;

class SerializerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Serializer */
    protected $instance;

    public function testCreateJsonSerializer()
    {
        $this->instance = SerializerFactory::getSerializer(
            Serializer::FORMAT_JSON,
            Serializer::MAX_DEPTH_NOT_SET,
            'test/config/'
        );

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

    public function testCanIterateOnArrayReturnsTrue()
    {
        $testData = array();

        $this->assertTrue(SerializerFactory::canIterate($testData));
    }

    public function testCanIterateOnScalarReturnsFalse()
    {
        $testData = PHP_INT_MAX;

        $this->assertFalse(SerializerFactory::canIterate($testData));
    }

    public function testCanIterateOnIterableObjectReturnsTrue()
    {
        $testData = new \ArrayObject();

        $this->assertTrue(SerializerFactory::canIterate($testData));
    }

    public function testCanIterateOnStandardObjectReturnsFalse()
    {
        $testData = new SimpleClass();

        $this->assertFalse(SerializerFactory::canIterate($testData));
    }
}
