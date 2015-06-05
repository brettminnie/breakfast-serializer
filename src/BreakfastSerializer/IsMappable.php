<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Interface IsMappable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsMappable
{
    /**
     * @param string $propertyName
     * @return boolean
     */
    public function isMappable($propertyName);

    /**
     * @param string $property
     * @param array $data
     * @return IsMappable
     */
    public function remapProperty($property, array $data);

    /**
     * @param string $property
     * @param array $data
     * @return IsMappable
     */
    public function mapProperty($property, array $data);
}
