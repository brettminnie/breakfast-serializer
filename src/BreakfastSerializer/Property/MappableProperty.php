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
                array_flip(
                    $configuration['mappings'][$currentClassName]['mappedVariables']
                )
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
            
            $this->{$keyName} =
                clone $this->{$configuration['mappings'][$currentClassName]['mappedVariables'][$property]};

            unset($this->{$keyName});
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function mapProperty($property, array $configuration)
    {
        $currentClassName = get_class($this);

        if (true === property_exists($this, $property)) {
            $this->{$configuration['mappings'][$currentClassName]['mappedVariables'][$property]}
                = clone $this->{$property};

            unset($this->{$property});
        }

        return $this;
    }
}
