<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\Property\IsMappable;
use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;
use BDBStudios\BreakfastSerializerTest\Fixtures\MappingClass;
use BDBStudios\BreakfastSerializerTest\Fixtures\NoConfigMappingClass;

class MappingPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MappingClass
     */
    protected $instance;

    /**
     * @var mixed
     */
    protected static $serializedMappedInstance;

    /**
     * @var array
     */
    protected static $data;

    /** @var  JSONSerializer */
    protected $serializer;

    public function setUp()
    {
        $this->instance = new MappingClass();
        $this->instance->initForTest();

        SerializerFactory::destroySerializer();
        $this->serializer = SerializerFactory::getSerializer(
            Serializer::FORMAT_JSON,
            Serializer::MAX_DEPTH_NOT_SET,
            'test/config'
        );
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof IsMappable);
    }

    public function testPropertyThreeIsMappable()
    {
        $this->assertTrue(
            $this->instance->isPropertyMappable(
                'mappedPropertyOne',
                get_class($this->instance),
                $this->serializer->getConfiguration()
            )
        );
    }

    public function testNonExistentPropertyIsNotMappable()
    {
        $propertyName = uniqid('property');
        $this->assertFalse(
            $this->instance->isPropertyMappable(
                $propertyName,
                get_class($this->instance),
                $this->serializer->getConfiguration()
            )
        );
    }

    public function testNonMappedClassIsNotMappable()
    {
        $instance = new NoConfigMappingClass();
        $this->assertFalse(
          $instance->isPropertyMappable(
              'notSetForMapping',
              get_class($instance),
              $this->serializer->getConfiguration()
          )
        );
    }

    public function testIsMappedReturnsTrueOnValidProperty()
    {
        $this->assertTrue(
            $this->instance->isPropertyMapped(
                'propertyThree',
                get_class($this->instance),
                $this->serializer->getConfiguration()
            )
        );
    }

    public function testIsMappedReturnsFalseOnNonMappedProperty()
    {
        $this->assertFalse(
            $this->instance->isPropertyMapped(
                'propertyOne',
                get_class($this->instance),
                $this->serializer->getConfiguration()
            )
        );
    }

    public function testIsMappedReturnsFalseOnNonExistantProperty()
    {
        $instance = new NoConfigMappingClass();
        $this->assertFalse(
            $instance->isPropertyMapped(
                'invalidProperty',
                get_class($instance),
                $this->serializer->getConfiguration()
            )
        );
    }

    public function testPropertiesAreMapped()
    {
        $mockedSerializedInstance = (array)$this->instance;

        foreach ($mockedSerializedInstance  as $key=>$val) {
            $mockedSerializedInstance[str_replace('*', '', $key)] = $val;
            unset($key);
        }

        $className = get_class($this->instance);
        $mappableProperties = $this->serializer->getConfiguration()['mappings'][$className]['mappedVariables'];

        //Does our serialized class have our expected keys
        foreach (array_keys($mappableProperties) as $propertyName) {
            $this->assertFalse(array_key_exists($propertyName, $mockedSerializedInstance));
        }

        self::$serializedMappedInstance = $this->serializer->serialize($this->instance);
        $this->assertNotEquals(json_encode($mockedSerializedInstance), self::$serializedMappedInstance);

        //Does our serialized class have our expected keys
        foreach (array_keys($mappableProperties) as $propertyName) {
            $this->assertNotContains($propertyName, self::$serializedMappedInstance);
        }
    }

    public function testDeserializeCorrectlyMapsProperties()
    {
        $remappedClass =
            $this->serializer->deserialize(self::$serializedMappedInstance);

        $mappedClass = json_decode(self::$serializedMappedInstance, true);

        $this->assertNotEquals($remappedClass, $mappedClass);

        foreach($remappedClass as $item) {
            $this->assertTrue(in_array($item, $mappedClass));
        }

        $this->assertEquals(
            $remappedClass,
            $this->serializer->deserialize(self::$serializedMappedInstance)
        );
    }
}
