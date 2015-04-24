<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Interface IsDepthTraversable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsDepthTraversable
{
    /**
     * @param int $depth
     * @return IsSerializable
     * @throws \LogicException
     */
    public function setDepth($depth);

    /**
     * @return int
     */
    public function getDepth();
}
