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
                    $configuration['exclusions'][$currentClassName]['mappedVariables']
                )
            );
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function remapProperty($property, array $data)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function mapProperty($property, array $data)
    {
        return $this;
    }
}
