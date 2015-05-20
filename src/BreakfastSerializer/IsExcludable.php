<?php

namespace BDBStudios\BreakfastSerializer;

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
