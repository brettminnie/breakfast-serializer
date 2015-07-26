<?php

namespace BDBStudios\BreakfastSerializer\Property;

use Symfony\Component\Yaml\Exception\ParseException;
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

    /**
     * @return IsConfigurable
     * @throws \LogicException
     * @throws ParseException
     */
    public function loadConfiguration();
}

