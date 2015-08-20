<?php

namespace BDBStudios\BreakfastSerializer\Plugin;

/**
 * Interface PluginInterface
 * @package BDBStudios\BreakfastSerializer\Plugin
 */
interface PluginInterface
{
    /**
     * @return PluginInterface
     */
    public function register();

    /**
     * @return PluginInterface
     */
    public function unregister();

    /**
     * @return PluginInterface
     */
    public function activate();

    /**
     * @return PluginInterface
     */
    public function deactivate();

    /**
     * @return boolean
     */
    public function isActive();

    /**
     * @param mixed $value
     * @return PluginInterface
     */
    public function execute(&$value = null);

    /**
     * @return string
     */
    public function getName();
}
