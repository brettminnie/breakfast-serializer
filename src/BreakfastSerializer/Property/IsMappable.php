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
    public function isMappable($propertyName, $currentClassName, array $configuration);

    /**
     * @param string $property
     * @param array $configuration
     * @return IsMappable
     */
    public function remapProperty($property, array $configuration);

    /**
     * @param string $property
     * @param array $configuration
     * @return IsMappable
     */
    public function mapProperty($property, array $configuration);
}
