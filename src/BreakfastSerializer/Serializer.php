<?php

namespace BDBStudios\BreakfastSerializer;

use BDBStudios\BreakfastSerializer\Property\ConfigurableProperty;
use BDBStudios\BreakfastSerializer\Property\ExcludableProperty;
use BDBStudios\BreakfastSerializer\Property\IsConfigurable;
use BDBStudios\BreakfastSerializer\Property\IsDepthTraversable;
use BDBStudios\BreakfastSerializer\Property\IsExcludable;
use BDBStudios\BreakfastSerializer\Property\IsMappable;
use BDBStudios\BreakfastSerializer\Property\MappableProperty;
use BDBStudios\BreakfastSerializer\Property\DepthTraversableProperty;

/**
 * Class Serializer
 * @package BDBStudios\BreakfastSerializer
 */
abstract class Serializer implements IsSerializable, IsDepthTraversable, IsConfigurable, IsExcludable, IsMappable
{
    use ConfigurableProperty;
    use MappableProperty;
    use ExcludableProperty;
    use DepthTraversableProperty;

    /**
     * @var int
     */
    protected $format;

    /**
     * @param int    $dataFormat
     * @param int    $maxDepth
     * @param string $configurationPath
     */
    public function __construct(
        $dataFormat = Serializer::FORMAT_XML,
        $maxDepth = Serializer::MAX_DEPTH_NOT_SET,
        $configurationPath = './config'
    )
    {
        $this->format = $dataFormat;
        $this->maxDepth = $maxDepth;
        $this->configurationPath = $configurationPath;
        $this->currentDepth = 1;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @inheritdoc
     */
    abstract public function deserialize($data);

    /**
     * @inheritdoc
     */
    abstract public function serialize($data);

    /**
     * @param string  $variableName
     * @param mixed   $containingClass
     * @return string
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function cleanVariableName($variableName, $containingClass)
    {
        $className = '';

        if (true === is_object($containingClass)) {
            $className = get_class($containingClass);
        } elseif (true === is_array($containingClass)) {
            $className = get_class(array_pop($containingClass));
        }

        $cleanedName = str_replace('*', '', $variableName);
        $cleanedName = str_replace($className, '', $cleanedName);

        return trim($cleanedName);
    }

    /**
     * @param array  $objAsArray
     * @param array  $data
     * @param bool   $exposeClassName
     * @param object $baseObject
     * @param string $currentClassName
     */
    abstract protected function iterateClassProperties(
        array $objAsArray,
        array& $data,
        $exposeClassName,
        $baseObject,
        $currentClassName
    );

    /**
     * @param array  $data
     * @param object $baseObject
     * @param string $currentClassName
     * @param string $key
     * @param mixed  $val
     */
    protected function SanitizeAndMapProperty(array& $data, $baseObject, $currentClassName, $key, $val)
    {
        $cleanedVariableName = $this->cleanVariableName($key, $baseObject);
        $this->includeClassProperty($data, $cleanedVariableName, $currentClassName, $val);
        $this->mapClassProperty($data, $cleanedVariableName, $currentClassName, $val);
    }

    /**
     * @param array  $data
     * @param string $cleanedVariableName
     * @param string $currentClassName
     * @param mixed  $val
     */
    protected function mapClassProperty(array& $data, &$cleanedVariableName, $currentClassName, $val)
    {
        $configuration = $this->getConfiguration();

        if ($this->isPropertyMappable(
            $cleanedVariableName,
            $currentClassName,
            $configuration
        )) {
            $data[$configuration['mappings'][$currentClassName]['mappedVariables'][$cleanedVariableName]] = $val;
            unset($data[$cleanedVariableName]);
        }
    }

    /**
     * @param array& $data
     * @param string $cleanedVariableName
     * @param string $currentClassName
     * @param mixed  $val
     * @return bool
     */
    protected function includeClassProperty(array& $data, $cleanedVariableName, $currentClassName, $val)
    {
        if (false === $this->isExcluded(
            $cleanedVariableName,
            $currentClassName,
            $this->getConfiguration()
        )) {
            $data[$cleanedVariableName] = $val;
        }
    }
}
