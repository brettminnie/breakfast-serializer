<?php

namespace BDBStudios\BreakfastSerializerTests;

use BDBStudios\BreakfastSerializer\IsConfigurable;
use BDBStudios\BreakfastSerializerTest\Fixtures\ConfigurationStub;

class ConfigurablePropertyTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ConfigurationStub */
    protected $instance;

    public function setUp()
    {
        $this->instance = new ConfigurationStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof IsConfigurable);
    }

    public function testSetGetConfigurationPath()
    {
        $path = '/tmp';

        $this->assertTrue(
            $this->instance->setConfigurationPath($path) instanceof IsConfigurable
        );

        $this->assertEquals($path, $this->instance->getConfigurationPath());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The path to the configuration file is invalid
     */
    public function testGetConfigurationLoadsConfigurationWithNoPathFails()
    {
        $this->instance->getConfiguration();
    }

    public function testGetConfigurationLoadsConfiguration()
    {
        $this->assertTrue($this->instance->setConfigurationPath('./config') instanceof IsConfigurable);
        $return = $this->instance->getConfiguration();
        $this->assertTrue(is_array($return));
        $this->assertArrayHasKey('serializer', $return);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The path to the configuration file is invalid
     */
    public function testLoadConfigurationWithInvalidPathThrowsException()
    {
        $path = "/does/not/exist";

        $this->assertTrue(
            $this->instance->setConfigurationPath($path) instanceof IsConfigurable
        );

        $this->instance->loadConfiguration();
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testLoadConfigurationWithBadYamlThrowsException()
    {
        $path = "./test/badconfig";

        $this->assertTrue(
            $this->instance->setConfigurationPath($path) instanceof IsConfigurable
        );

        $this->instance->loadConfiguration();
    }
}
