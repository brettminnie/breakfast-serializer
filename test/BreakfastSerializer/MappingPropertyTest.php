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
            $this->instance->isMappable(
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
            $this->instance->isMappable(
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
          $instance->isMappable(
              'notSetForMapping',
              get_class($instance),
              $this->serializer->getConfiguration()
          )
        );
    }

    public function testPropertiesAreMapped()
    {
        $serializedInstance = $this->serializer->serialize($this->instance);

        $className = get_class($this->instance);
        $mappableProperties = $this->serializer->getConfiguration()['mappings'][$className]['mappedVariables'];

        //Does our serialized class have our expected keys
        foreach (array_keys($mappableProperties) as $propertyName) {
            $this->assertContains($propertyName, $serializedInstance);
        }

        //Map each property
        foreach (array_keys($mappableProperties) as $propertyName) {
            $this->instance = $this->instance->mapProperty($propertyName, $this->serializer->getConfiguration());
            $this->assertTrue($this->instance instanceof IsMappable);
        }

        self::$serializedMappedInstance = $this->serializer->serialize($this->instance);

        $this->assertNotEquals($serializedInstance, self::$serializedMappedInstance);

        //Does our serialized class have our expected keys
        foreach (array_keys($mappableProperties) as $propertyName) {
            $this->assertNotContains($propertyName, self::$serializedMappedInstance);
        }
    }

    public function testDeserializeCorrectlyMapsProperties()
    {
        $remappedClass =
            $this->serializer->deserialize(self::$serializedMappedInstance);

//        var_dump($remappedClass);
    }
}
