<?php

namespace BDBStudios\BreakfastSerializerTest\Plugin\DateTime\DateTimeHandler;

use BDBStudios\BreakfastSerializer\Plugin\DateTime\DateTimeHandler;
use BDBStudios\BreakfastSerializer\Plugin\PluginAbstract;
use BDBStudios\BreakfastSerializer\Plugin\PluginRegistry;

class DateTimeHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateTimeHandler
     */
    protected $plugin;

    public function setUp()
    {
        $this->plugin = new DateTimeHandler();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->plugin instanceof DateTimeHandler);
    }

    public function testICanRegisterThePlugin()
    {
        $this->assertFalse(PluginRegistry::isRegistered($this->plugin));
        $this->assertTrue(PluginRegistry::registerPlugin($this->plugin) instanceof PluginAbstract);
        $this->assertTrue(PluginRegistry::isRegistered($this->plugin));
    }

    public function testICanConvertADateTimeToAnIsoString()
    {
        $expected = new \DateTime();

        $this->assertEquals(
            PluginRegistry::getPlugin($this->plugin)['plugin']->execute($expected),
            $this->plugin
        );

        $this->assertFalse($expected instanceof \DateTime);
        $this->assertTrue($this->plugin->isISO8601String($expected));
    }

    public function testICanConvertAnIsoStringToADateTime()
    {
        $expected = (new \DateTime())->format(\DateTime::ISO8601);

        $this->assertEquals(
            PluginRegistry::getPlugin($this->plugin)['plugin']->execute($expected),
            $this->plugin
        );

        $this->assertTrue($expected instanceof \DateTime);
        $this->assertFalse($this->plugin->isISO8601String($expected));
    }

    public function testAnArbitraryValueIsNotConverted()
    {
        $expected = array('foo', 'bar');
        $original = $expected;
        $this->assertEquals(
            PluginRegistry::getPlugin($this->plugin)['plugin']->execute($expected),
            $this->plugin
        );

        $this->assertFalse($this->plugin->isDateTime($expected));
        $this->assertFalse($this->plugin->isISO8601String($expected));
        $this->assertEquals($original, $expected);
    }
}
