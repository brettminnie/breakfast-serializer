<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\IsSerializable;
use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;
use BDBStudios\BreakfastSerializerTest\Fixtures\ComplexClass;
use BDBStudios\BreakfastSerializerTest\Fixtures\ConstructorWithArgumentsClass;
use BDBStudios\BreakfastSerializerTest\Fixtures\SimpleClass;
use BDBStudios\BreakfastSerializerTest\Fixtures\SimpleContainer;

/**
 * Class SerializerTest
 * @package BDBStudios\BreakfastSerializerTests
 */
class JsonSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JSONSerializer
     */
    protected static $instance;

    public function setUp()
    {
        self::$instance = SerializerFactory::getSerializer(
            Serializer::FORMAT_JSON,
            Serializer::MAX_DEPTH_NOT_SET,
            'test/config'

        );
    }

    public function testSetUp()
    {
        $this->assertTrue(self::$instance instanceof JSONSerializer);
        $this->assertEquals(JSONSerializer::FORMAT_JSON, self::$instance->getFormat());
    }

    public function testSerializeSimpleClass()
    {
        $testInstance = new SimpleClass();

        $data = self::$instance->serialize($testInstance);
        $this->assertTrue(is_string($data));

        $data = json_decode($data, true);
        $this->assertTrue(is_array($data));

        $this->assertTrue(array_key_exists('name', $data));
        $this->assertTrue(array_key_exists('uid', $data));
    }


    public function testSerializeSimpleContainer()
    {
        $test = new SimpleContainer();
        $data = self::$instance->serialize($test);

        $this->assertTrue(is_string($data));
        $decodedData = json_decode($data, true);

        $this->assertTrue(is_array($decodedData));

        $this->assertCount(2, $decodedData['simpleArray']);

        $this->assertEquals('SimpleContainer Instance', $decodedData['name']);
        $this->assertEquals('SimpleClass Instance', $decodedData['simpleArray'][0]['name']);

        $this->assertTrue(array_key_exists('className', $decodedData));
        $this->assertTrue(array_key_exists('className', $decodedData['simpleArray'][0]));
    }

    public function testDeserialize()
    {
        $test = new SimpleClass();
        $data = self::$instance->serialize($test);

        $deserializedObject = self::$instance->deserialize($data);

        $this->assertEquals($test, $deserializedObject);
    }

    public function testComplexDeserialize()
    {
        $test = new SimpleContainer();
        $data = self::$instance->serialize($test);

        $deserializedObject = self::$instance->deserialize($data);

        $this->assertEquals($test, $deserializedObject);
    }

    public function testComplexSerializeLimitedToDepthOfOne()
    {
        $test = new SimpleContainer();

        self::$instance->setDepth(1);
        $data = self::$instance->serialize($test);
        $data = json_decode($data, true);
        $this->assertEmpty($data['simpleArray']);

        self::$instance->setDepth(IsSerializable::MAX_DEPTH_NOT_SET);
        $data = self::$instance->serialize($test);
        $data = json_decode($data, true);
        $this->assertNotEmpty($data['simpleArray']);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Unsupported data type: String expected however array received
     */
    public function testDeserializeArrayThrowsException()
    {
        $data = array();
        self::$instance->deserialize($data);
    }

    public function testMoreComplexClassSerializes()
    {
        $instance = new ComplexClass();

        $serializedInstance = self::$instance->serialize($instance);

        $deserializedInstance = self::$instance->deserialize($serializedInstance);

        $this->assertEquals($instance->__get('dataStore'), $deserializedInstance->__get('dataStore'));
    }

    public function testConstructorWithArgumentsIsCorrectlyHandled()
    {
        $expected = 'This is a test string value';
        $instance =  new ConstructorWithArgumentsClass($expected);

        $this->assertEquals($expected, $instance->__get('someValue'));

        $serializedInstance = self::$instance->serialize($instance);

        $deserializedInstance = self::$instance->deserialize($serializedInstance);

        $this->assertEquals($instance->__get('someValue'), $deserializedInstance->__get('someValue'));

    }
}
