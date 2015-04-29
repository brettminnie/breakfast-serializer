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
     * @return boolean
     */
    public function isExcluded($propertyName);
}
