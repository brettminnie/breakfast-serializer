<?php

namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Interface IsDepthTraversable
 * @package BDBStudios\BreakfastSerializer
 */
interface IsDepthTraversable
{
    /**
     * @param int $depth
     * @return IsDepthTraversable
     * @throws \LogicException
     */
    public function setDepth($depth);

    /**
     * @return int
     */
    public function getDepth();

    /**
     * @return IsDepthTraversable
     */
    public function incrementCurrentDepth();

    /**
     * @return IsDepthTraversable
     */
    public function decrementCurrentDepth();

    /**
     * @return boolean
     */
    public function isWithinBounds();

    /**
     * @return IsDepthTraversable
     */
    public function resetCurrentDepth();

    /**
     * @return int
     */
    public function getCurrentDepth();

}
