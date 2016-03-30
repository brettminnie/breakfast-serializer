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
     * @param PluginAbstract $plugin
     * @return bool
     */
    public static function isRegistered(PluginAbstract $plugin)
    {
        return array_key_exists($plugin->getName(), self::$data);
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
                'classPath' => get_class($plugin),
                'plugin'    => $plugin
            );
        }

        return $plugin;
    }

    /**
     * @param PluginAbstract $plugin
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
     * @param  PluginAbstract $plugin
     * @return PluginAbstract
     * @throws PluginNotFoundException
     */
    public static function getPlugin(PluginAbstract $plugin)
    {
        if (true === self::isRegistered($plugin)) {
            return self::$data[$plugin->getName()];
        }

        throw new PluginNotFoundException(
            sprintf(
                'The plugin %s was not found in the registry',
                $plugin->getName()
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
