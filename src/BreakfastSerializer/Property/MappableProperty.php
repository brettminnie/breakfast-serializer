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
    public function isMappable($propertyName, $currentClassName, array $configuration)
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
    public function remapProperty($property, array $configuration)
    {
        $currentClassName = get_class($this);

        if (false === property_exists($this, $property)) {
            $keyName = array_flip($configuration['mappings'][$currentClassName]['mappedVariables'][$property]);

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
