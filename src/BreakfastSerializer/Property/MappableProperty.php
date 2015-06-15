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
    public function isMappable($propertyName)
    {

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
