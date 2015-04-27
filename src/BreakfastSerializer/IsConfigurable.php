<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Interface IsConfigurable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsConfigurable
{
    /**
     * @param string $pathName
     * @return IsConfigurable
     */
    public function setConfigurationPath($pathName = './config');

    /**
     * @return string
     */
    public function getConfigurationPath();

    /**
     * @param string    $configurationKey
     * @return boolean
     */
    public function getConfiguration($configurationKey = null);
}

