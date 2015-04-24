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

    /**
     * @return IsSerializable
     */
    public function incrementCurrentDepth();

    /**
     * @return IsSerializable
     */
    public function decrementCurrentDepth();

    /**
     * @return boolean
     */
    public function isWithinBounds();

    /**
     * @return IsSerializable
     */
    public function resetCurrentDepth();

    /**
     * @return int
     */
    public function getCurrentDepth();

}
