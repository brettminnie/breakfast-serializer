<?php

namespace BDBStudios\BreakfastSerializerTests\Plugin;

use BDBStudios\BreakfastSerializer\Plugin\PluginAbstract;
use BDBStudios\BreakfastSerializer\Plugin\PluginRegistry;

class PluginAbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var  PluginAbstract */
    protected $instance;

    protected $pluginName;

    public function __construct()
    {
        $this->pluginName  = 'testPlugin' . uniqid();
        parent::__construct();
    }

    public function setUp()
    {
        $this->instance = \Mockery::mock(
            'BDBStudios\BreakfastSerializer\Plugin\PluginAbstract',
            array($this->pluginName, true)
        )
        ->shouldDeferMissing();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof PluginAbstract);
        $this->assertTrue($this->instance->isActive());
        $this->assertEquals($this->pluginName, $this->instance->getName());
    }

    public function testICanDeactivateThenReactivateAPlugin()
    {
        $this->assertTrue($this->instance->isActive());
        $this->assertTrue($this->instance->deactivate() instanceof PluginAbstract);
        $this->assertFalse($this->instance->isActive());
        $this->assertTrue($this->instance->activate() instanceof PluginAbstract);
        $this->assertTrue($this->instance->isActive());
    }

    public function testICanRegisterAPlugin()
    {
        $this->assertFalse(PluginRegistry::isRegistered($this->instance));
        $this->assertTrue($this->instance->register() instanceof PluginAbstract);
        $this->assertTrue(PluginRegistry::isRegistered($this->instance));
    }

    public function testICanUnregisterAPlugin()
    {
        $this->assertFalse(PluginRegistry::isRegistered($this->instance));
        $this->assertTrue($this->instance->register() instanceof PluginAbstract);
        $this->assertTrue(PluginRegistry::isRegistered($this->instance));
        $this->assertTrue($this->instance->unregister() instanceof PluginAbstract);
        $this->assertFalse(PluginRegistry::isRegistered($this->instance));
    }
}
