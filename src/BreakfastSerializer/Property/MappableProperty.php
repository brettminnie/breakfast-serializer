<?php

namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Class MappableProperty
 * @package BDBStudios\BreakfastSerializer
 */
trait MappableProperty
{
    /**
     * @inheritdoc
     */
    public function isPropertyMappable($propertyName, $currentClassName, array $configuration)
    {
        if (true === isset($configuration['mappings'][$currentClassName]['mappedVariables'])) {
            return array_key_exists(
                $propertyName,
                $configuration['mappings'][$currentClassName]['mappedVariables']
            );
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function isPropertyMapped($propertyName, $currentClassName, array $configuration)
    {
        if (true === isset($configuration['mappings'][$currentClassName]['mappedVariables'])) {
            return in_array(
                $propertyName,
                $configuration['mappings'][$currentClassName]['mappedVariables']
            );
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function remapProperty($property, $currentClassName, array $configuration)
    {
        if (false === property_exists($currentClassName, $property) &&
            true === in_array($property, $configuration['mappings'][$currentClassName]['mappedVariables'])) {
            $keyName = array_flip($configuration['mappings'][$currentClassName]['mappedVariables'])[$property];

            return $keyName;
        }

        return $property;
    }

    /**
     * @inheritdoc
     */
    public function mapProperty($property, array $configuration)
    {
        $currentClassName = get_class($this);
        $instance = clone $this;
        if (true === property_exists($this, $property)) {
            $instance->{$configuration['mappings'][$currentClassName]['mappedVariables'][$property]}
                = $instance->{$property};

            unset($instance->{$property});
        }

        return $instance;
    }
}
