<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializerTests\Fixtures\SimpleClass;
use BDBStudios\BreakfastSerializerTests\Fixtures\SimpleContainer;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $instance;

    public function setUp()
    {
        $this->instance = Serializer::getSerializer();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof Serializer);
        $this->assertEquals(Serializer::FORMAT_JSON, $this->instance->getFormat());
    }

    public function testSerializeSimpleClass()
    {
        $testInstance = new SimpleClass();

        $data = $this->instance->serialize($testInstance);
        $this->assertTrue(is_string($data));

        $data = json_decode($data, true);
        $this->assertTrue(is_array($data));

        $this->assertTrue(array_key_exists('name', $data));
        $this->assertTrue(array_key_exists('uid', $data));
    }


    public function testSerializeSimpleContainer()
    {
        $test = new SimpleContainer();
        $data = $this->instance->serialize($test);

        $this->assertTrue(is_string($data));
        $decodedData = json_decode($data, true);

        $this->assertTrue(is_array($decodedData));

        $this->assertCount(2, $decodedData['simpleArray']);

        $this->assertEquals('SimpleContainer Instance', $decodedData['name']);
        $this->assertEquals('SimpleClass Instance', $decodedData['simpleArray'][0]['name']);

        $this->assertTrue(array_key_exists('className', $decodedData));
        $this->assertTrue(array_key_exists('className', $decodedData['simpleArray'][0]));
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Currently only JSON is supported
     */
    public function testSerializeUnsupportedFormatThrowsException()
    {
        $object = new \stdClass();
        $this->instance->serialize($object, Serializer::FORMAT_PHP);
    }

    public function testDeserialize()
    {
        $test = new SimpleClass();
        $data = $this->instance->serialize($test);

        $deserializedObject = $this->instance->deserialize($data);

        $this->assertEquals($test, $deserializedObject);
    }

    public function testComplexDeserialize()
    {
        $test = new SimpleContainer();
        $data = $this->instance->serialize($test);

        $deserializedObject = $this->instance->deserialize($data);

        $this->assertEquals($test, $deserializedObject);
    }
}
