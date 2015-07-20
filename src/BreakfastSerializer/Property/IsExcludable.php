<?php

namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Interface IsExcludable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsExcludable
{
    /**
     * @param string $propertyName
     * @param string $currentClassName
     * @param array  $configuration
     * @return boolean
     */
    public function isExcluded($propertyName, $currentClassName, array $configuration);
}
