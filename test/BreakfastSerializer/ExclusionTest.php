<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\Serializer;
use BDBStudios\BreakfastSerializerTest\Fixtures\ExclusionClass;

class ExclusionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExclusionClass
     */
    protected $instance;

    /** @var  Serializer */
    protected $serializer;

    public function setUp()
    {
        $this->instance = new ExclusionClass();

        $this->serializer =
            \Mockery::mock(
                'BDBStudios\BreakfastSerializer\Serializer',
                array(Serializer::FORMAT_JSON, Serializer::MAX_DEPTH_NOT_SET)
            )
                ->shouldDeferMissing();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof ExclusionClass);
        $this->assertTrue($this->serializer instanceof Serializer);
    }

    public function testExclusionOfProperties()
    {

    }
}
