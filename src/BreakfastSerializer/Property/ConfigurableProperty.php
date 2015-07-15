<?php

namespace BDBStudios\BreakfastSerializer\Property;

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
     * @inheritdoc
     */
    public function setConfigurationPath($pathName = './config')
    {
        $this->configurationPath = $pathName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getConfigurationPath()
    {
        return $this->configurationPath;
    }

    /**
     * @inheritdoc
     */
    public function getConfiguration($configurationKey = null)
    {
        if (empty(self::$configurationData)) {
            $this->loadConfiguration();
        }

        return (true === is_null($configurationKey)) ?
            self::$configurationData :
            self::$configurationData[$configurationKey];
    }

    /**
     * @inheritdoc
     */
    public function loadConfiguration()
    {
        if (false === $this->configurationPathIsValid()) {
            throw new \LogicException('The path to the configuration file is invalid');
        }

        self::$configurationData = array();
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->configurationPath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $fileData = Yaml::parse(file_get_contents($file->getRealPath()));

            if (true === is_array($fileData)) {
                self::$configurationData =
                    array_merge(
                        self::$configurationData,
                        $fileData
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
