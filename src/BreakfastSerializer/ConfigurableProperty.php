<?php

namespace BDBStudios\BreakfastSerializer;

use Symfony\Component\Yaml\Exception\ParseException;
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
        if (empty(self::$configurationData)) {
            $this->loadConfiguration();
        }

        return (true === is_null($configurationKey)) ?
            self::$configurationData : self::$configurationData[$configurationKey];
    }

    /**
     * @return IsConfigurable
     * @throws \LogicException
     * @throws ParseException
     */
    protected function loadConfiguration()
    {
        if (false === $this->configurationPathIsValid()) {
            throw new \LogicException('The path to the configuration file is invalid');
        }

        self::$configurationData = array();
        $iterator = new \DirectoryIterator($this->configurationPath);

        foreach ($iterator as $file) {
            if (false === $file->isDot()) {
                self::$configurationData =
                    array_merge(
                        self::$configurationData,
                        Yaml::parse(
                            file_get_contents(
                                $file->getRealPath()
                            )
                        )
                    );
            }
        }

        return $this;
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
