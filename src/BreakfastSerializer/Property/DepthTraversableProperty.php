<?php


namespace BDBStudios\BreakfastSerializer\Property;

/**
 * Class DepthTraversableProperty
 * @package BDBStudios\BreakfastSerializer\Property
 */
trait DepthTraversableProperty
{
    /**
     * @var int
     */
    protected $maxDepth;

    /**
     * @var int
     */
    protected $currentDepth;

    /**
     * @inheritdoc
     */
    public function setDepth($maxDepth)
    {
        if ($maxDepth !== self::MAX_DEPTH_NOT_SET) {
            if (false === is_int($maxDepth)) {
                throw new \LogicException(__CLASS__ . '::' . __FUNCTION__ . ' expects an int but a ' . gettype($maxDepth) . ' was supplied');
            } elseif ($maxDepth <= 0) {
                throw new \LogicException('The maximum depth should be non zero, non negative');
            }
        }

        $this->maxDepth = $maxDepth;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDepth()
    {
        return $this->maxDepth;
    }

    /**
     * @inheritdoc
     */
    public function incrementCurrentDepth()
    {
        $this->currentDepth++;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function decrementCurrentDepth()
    {
        $this->currentDepth =
            (1 <= $this->currentDepth) ? 1 : $this->currentDepth = 1;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentDepth()
    {
        return $this->currentDepth;
    }

    /**
     * @inheritdoc
     */
    public function resetCurrentDepth()
    {
        $this->currentDepth = 1;
    }


    /**
     * @inheritdoc
     */
    public function isWithinBounds()
    {
        $isValid = (self::MAX_DEPTH_NOT_SET === $this->maxDepth)
            ? true : ($this->currentDepth <= $this->maxDepth)
                ? true : false;

        return $isValid;
    }


}
