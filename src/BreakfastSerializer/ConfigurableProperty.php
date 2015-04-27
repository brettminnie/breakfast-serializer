<?php

namespace BDBStudios\BreakfastSerializer;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigurableProperty
 * @package BDBStudios\BreakfastSerializer
 */
trait ConfigurableProperty
{

    /**
     * @var string
     */
    protected $configurationPath;

    /**
     * @var array
     */
    protected static $configurationData;

    public function __construct()
    {
        self::$configurationData = array();
        $this->configurationPath = '';
    }

    /**
     * @param string $pathName
     * @return IsConfigurable
     */
    public function setConfigurationPath($pathName = './config')
    {
        $this->configurationPath = $pathName;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfigurationPath()
    {
        return $this->configurationPath;
    }

    /**
     * @param string    $configurationKey
     * @return boolean
     */
    public function getConfiguration($configurationKey = null)
    {
        return (true === is_null($configurationKey)) ?
            self::$configurationData : self::$configurationData[$configurationKey];
    }

    /**
     * @return boolean
     */
    protected function loadConfiguration()
    {
        $this->configurationPathIsValid();
    }

    /**
     * @return bool
     */
    protected function configurationPathIsValid()
    {
        return (
            false === empty(
                trim($this->configurationPath)
            )
            &&
            false !== realpath(
                $this->configurationPath
            )
        );
    }
}