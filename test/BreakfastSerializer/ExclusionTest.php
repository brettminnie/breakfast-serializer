<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\JSONSerializer;
use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializer\SerializerFactory;
use BDBStudios\BreakfastSerializerTest\Fixtures\ExclusionClass;

class ExclusionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExclusionClass
     */
    protected $instance;

    /**
     * @var array
     */
    protected static $data;

    /** @var  JSONSerializer */
    protected $serializer;

    public function setUp()
    {
        $this->instance = new ExclusionClass();
        $this->instance->initForTest();

        $this->serializer = SerializerFactory::getSerializer(
            Serializer::FORMAT_JSON,
            Serializer::MAX_DEPTH_NOT_SET,
            'test/config/exclusions'
        );
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof ExclusionClass);
        $this->assertTrue($this->serializer instanceof Serializer);
    }

    public function testExclusionOfProperties()
    {
        $serialized = json_decode($this->serializer->serialize($this->instance), true);

        $this->assertArrayNotHasKey('internalProperty', $serialized);
        $this->assertArrayNotHasKey('excluded', $serialized);
        $this->assertArrayHasKey('propertyOne', $serialized);
        $this->assertArrayHasKey('propertyTwo', $serialized);
        $this->assertArrayHasKey('simpleInstance', $serialized);
        $this->assertArrayHasKey('className', $serialized);

        self::$data['originalData'] = $this->instance;
        self::$data['rawData']      = json_encode($serialized);
    }

    public function testDeserializePostExclusion()
    {
        /** @var ExclusionClass $entity */
        $entity = $this
            ->serializer
            ->deserialize(
                self::$data['rawData']
            );

        $this->assertTrue($entity instanceof ExclusionClass);
        $this->assertNotEquals($entity, self::$data['originalData']);

        $this->assertEmpty($entity->__get('internalProperty'));
        $this->assertNotEquals($entity->__get('internalProperty'), $this->instance->__get('internalProperty'));

        $this->assertEmpty($entity->__get('isExcluded'));
        $this->assertNotEquals($entity->__get('isExcluded'), $this->instance->__get('isExcluded'));

        $this->assertNotEmpty($entity->__get('propertyOne'));
        $this->assertEquals($entity->__get('propertyOne'), $this->instance->__get('propertyOne'));

        $this->assertNotEmpty($entity->__get('propertyTwo'));
        $this->assertEquals($entity->__get('propertyTwo'), $this->instance->__get('propertyTwo'));
    }


}
