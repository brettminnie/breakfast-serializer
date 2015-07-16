<?php

namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Interface IsMappable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsMappable
{
    /**
     * @param string $propertyName
     * @param string $currentClassName
     * @param array  $configuration
     * @return boolean
     */
    public function isPropertyMappable($propertyName, $currentClassName, array $configuration);

    /**
     * @param string $propertyName
     * @param string $currentClassName
     * @param array  $configuration
     * @return boolean
     */
    public function isPropertyMapped($propertyName, $currentClassName, array $configuration);

    /**
     * @param string $property
     * @param string $currentClassName
     * @param array $configuration
     * @return IsMappable
     */
    public function remapProperty($property, $currentClassName, array $configuration);

    /**
     * @param string $property
     * @param array $configuration
     * @return IsMappable
     */
    public function mapProperty($property, array $configuration);
}
