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
     * @param string $className
     * @return boolean
     */
    public function isExcluded($propertyName, $className);
}
