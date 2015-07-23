<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializerTest\Fixtures\ComplexClass;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Serializer */
    protected $instance;

    public function setUp()
    {
        $this->instance =
            \Mockery::mock(
                'BDBStudios\BreakfastSerializer\Serializer',
                array(Serializer::FORMAT_JSON, Serializer::MAX_DEPTH_NOT_SET)
            )
            ->shouldDeferMissing();
    }

    public function testSetup()
    {
        $this->assertTrue($this->instance instanceof Serializer);
    }

    public function testGetSetDepth()
    {
        $expected = 5;

        $this->assertEquals(Serializer::MAX_DEPTH_NOT_SET, $this->instance->getDepth());
        $this->assertTrue($this->instance->setDepth($expected) instanceof Serializer);
        $this->assertNotEquals(Serializer::MAX_DEPTH_NOT_SET, $this->instance->getDepth());
        $this->assertEquals($expected, $this->instance->getDepth());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage BDBStudios\BreakfastSerializer\Serializer::setDepth expects an int but a string was supplied
     */
    public function testGetSetDepthThrowsExceptionWithString()
    {
        $expected = 'five';
        $this->assertEquals(Serializer::MAX_DEPTH_NOT_SET, $this->instance->getDepth());
        $this->assertTrue($this->instance->setDepth($expected) instanceof Serializer);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The maximum depth should be non zero, non negative
     */
    public function testSettingDepthToZeroThrowsException()
    {
        $expected = 0;
        $this->assertEquals(Serializer::MAX_DEPTH_NOT_SET, $this->instance->getDepth());
        $this->assertTrue($this->instance->setDepth($expected) instanceof Serializer);
    }

    public function testIncrementDecrementCurrentDepth()
    {
        $maxDepth = 3;

        $this->instance->setDepth($maxDepth);
        $this->assertEquals($maxDepth, $this->instance->getDepth());
        $this->assertEquals(1, $this->instance->getCurrentDepth());
        $this->assertTrue($this->instance->incrementCurrentDepth() instanceof Serializer);
        $this->assertTrue($this->instance->isWithinBounds());
        $this->assertTrue($this->instance->incrementCurrentDepth() instanceof Serializer);
        $this->assertEquals($maxDepth, $this->instance->getCurrentDepth());
        $this->assertTrue($this->instance->isWithinBounds());
        $this->assertTrue($this->instance->incrementCurrentDepth() instanceof Serializer);
        $this->assertFalse($this->instance->isWithinBounds());
        $this->assertTrue($this->instance->decrementCurrentDepth() instanceof Serializer);
        $this->assertTrue($this->instance->isWithinBounds());

        $this->instance->resetCurrentDepth();
        $this->assertNotEquals($maxDepth, $this->instance->getCurrentDepth());
    }
}

