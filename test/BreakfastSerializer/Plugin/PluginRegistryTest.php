<?php

namespace BDBStudios\BreakfastSerializerTests\Plugin;

use BDBStudios\BreakfastSerializer\Plugin\PluginAbstract;
use BDBStudios\BreakfastSerializer\Plugin\PluginRegistry;

/**
 * Class PluginRepositoryTest
 * @package BDBStudios\BreakfastSerializerTests\Plugin
 */
class PluginRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PluginAbstract
     */
    protected $activePluginInstance;

    /**
     * @var PluginAbstract
     */
    protected $inactivePluginInstance;

    public function setUp()
    {
        $this->activePluginInstance =
            \Mockery::mock(
                'BDBStudios\BreakfastSerializer\Plugin\PluginAbstract',
                array('testActivePlugin', true)
            )
            ->shouldDeferMissing();

        $this->inactivePluginInstance =
            \Mockery::mock(
                'BDBStudios\BreakfastSerializer\Plugin\PluginAbstract',
                array('testInactivePlugin', true)
            )
            ->shouldDeferMissing();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->activePluginInstance instanceof PluginAbstract);
        $this->assertTrue($this->inactivePluginInstance instanceof PluginAbstract);
    }

    public function testICanAddAPluginToTheRegistry()
    {
        $this->assertFalse(PluginRegistry::isRegistered($this->activePluginInstance));
        $this->assertTrue(PluginRegistry::registerPlugin($this->activePluginInstance) instanceof PluginAbstract);
        $this->assertTrue(PluginRegistry::isRegistered($this->activePluginInstance));

        $this->assertEquals(
            get_class($this->activePluginInstance),
            PluginRegistry::getPlugin($this->activePluginInstance->getName())['classPath']
        );

        $this->assertEquals(
            $this->activePluginInstance->isActive(),
            PluginRegistry::getPlugin($this->activePluginInstance->getName())['active']
        );
    }

    public function testICanAddASecondPluginToTheRegistry()
    {
        $this->assertFalse(PluginRegistry::isRegistered($this->inactivePluginInstance));
        $this->assertTrue(PluginRegistry::registerPlugin($this->inactivePluginInstance) instanceof PluginAbstract);
        $this->assertTrue(PluginRegistry::isRegistered($this->inactivePluginInstance));

        $this->assertEquals(
            get_class($this->inactivePluginInstance),
            PluginRegistry::getPlugin($this->inactivePluginInstance->getName())['classPath']
        );

        $this->assertEquals(
            $this->activePluginInstance->isActive(),
            PluginRegistry::getPlugin($this->inactivePluginInstance->getName())['active']
        );
    }

    public function testICanRemoveAPluginFromTheRegistry()
    {
        $this->assertTrue(PluginRegistry::isRegistered($this->activePluginInstance));
        $this->assertTrue(PluginRegistry::unregisterPlugin($this->activePluginInstance) instanceof PluginAbstract);
        $this->assertFalse(PluginRegistry::isRegistered($this->activePluginInstance));
        $this->assertNull(PluginRegistry::getPlugin($this->activePluginInstance->getName()));
    }
}
