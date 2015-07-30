<?php

namespace BDBStudios\BreakfastSerializerTests\Property\TypeHandler;


use BDBStudios\BreakfastSerializer\Property\TypeHandler\IsDateTime;
use BDBStudios\BreakfastSerializerTest\Fixtures\TypeHandlers\DateTimeType;

class DateTimeHandler extends \PHPUnit_Framework_TestCase
{
    /** @var  DateTimeType */
    protected $instance;

    const ISO_REGEX = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(-|\+)\d{4}$/';

    public function setUp()
    {
        $this->instance = new DateTimeType();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof IsDateTime);
    }

    public function testIsDateTimeReturnsTrue()
    {
        $value = new \DateTime();

        $this->assertTrue($this->instance->isDateTime($value));
    }

    public function testIsDateTimeReturnsFalse()
    {
        $value = time();

        $this->assertFalse($this->instance->isDateTime($value));
    }

    public function testIsoStringConversion()
    {
        $value = new \DateTime();

        $isoValue = $this->instance->toISO8601Format($value);

        $this->assertEquals($value->format(\DateTime::ISO8601), $isoValue);
        $this->assertEquals(1, preg_match(self::ISO_REGEX, $isoValue));
        $this->assertTrue($this->instance->isISO8601String($isoValue));
        $this->assertEquals($value, $this->instance->fromISO8601Format($isoValue));
    }
}
