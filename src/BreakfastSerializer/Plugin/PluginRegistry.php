<?php

namespace BDBStudios\BreakfastSerializer\Plugin;

/**
 * Class PluginRegistry
 * @package BDBStudios\BreakfastSerializer\Plugin
 */
final class PluginRegistry
{
    /**
     * @var array
     */
    protected static $data = array();

    /**
     * @param string|PluginAbstract $plugin
     * @return bool
     */
    public static function isRegistered($plugin)
    {
        if ($plugin instanceof PluginAbstract) {
            $plugin = $plugin->getName();
        }

        return array_key_exists($plugin, self::$data);
    }

    /**
     * @param PluginAbstract  $plugin
     * @return PluginAbstract
     */
    public static function registerPlugin(PluginAbstract $plugin)
    {
        if (false === self::isRegistered($plugin)) {
            self::$data[$plugin->getName()] = array(
                'active'    => $plugin->isActive(),
                'classPath' => get_class($plugin)
            );
        }

        return $plugin;
    }

    /**
     * @param PluginAbstract  $plugin
     * @return PluginAbstract
     */
    public static function unregisterPlugin(PluginAbstract $plugin)
    {
        if (true === self::isRegistered($plugin)) {
            unset(self::$data[$plugin->getName()]);
        }

        return $plugin;
    }

    /**
     * @param $pluginName
     * @return mixed
     * @throws PluginNotFoundException
     */
    public static function getPlugin($pluginName)
    {
        if (true === self::isRegistered($pluginName)) {
            return self::$data[$pluginName];
        }

        throw new PluginNotFoundException(
            sprintf(
                'The plugin %s was not found in the registry',
                $pluginName
            )
        );
    }

    /**
     * @param  PluginAbstract $plugin
     * @return PluginAbstract
     */
    public static function setPlugin(PluginAbstract $plugin)
    {
        self::$data[$plugin->getName()] = array(
            'active'    => $plugin->isActive(),
            'classPath' => get_class($plugin)
        );

        return $plugin;
    }

}
