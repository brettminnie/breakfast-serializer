<?php

namespace BDBStudios\BreakfastSerializer\Plugin;

/**
 * Class PluginAbstract
 * @package BDBStudios\BreakfastSerializer\Plugin
 */
abstract class PluginAbstract implements PluginInterface
{
    /**
     * @var bool
     */
    protected $active;

    /**
     * @var string
     */
    protected $pluginName;

    /**
     * @param string $pluginName
     * @param bool   $active
     */
    public function __construct($pluginName, $active = true)
    {
        $this->pluginName = $pluginName;
        $this->active = $active;
    }

    /**
     * @inheritdoc
     */
    public abstract function execute();

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->pluginName;
    }

    /**
     * @inheritdoc
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @inheritdoc
     */
    public function activate()
    {
        $this->active = true;
        return PluginRegistry::setPlugin($this);
    }

    /**
     * @inheritdoc
     */
    public function deactivate()
    {
        $this->active = false;
        return PluginRegistry::setPlugin($this);
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        return PluginRegistry::registerPlugin($this);
    }

    /**
     * @inheritdoc
     */
    public function unregister()
    {
        return PluginRegistry::unregisterPlugin($this);
    }
}
