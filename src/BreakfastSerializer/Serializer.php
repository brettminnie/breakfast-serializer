<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class Serializer
 * @package BDBStudios\BreakfastSerializer
 */
abstract class Serializer implements IsSerializable, IsDepthTraversable
{
    /**
     * @var int
     */
    protected $maxDepth;

    /**
     * @var int
     */
    protected $format;

    /**
     * @param int $dataFormat
     * @param int $maxDepth
     */
    public function __construct(
        $dataFormat = Serializer::FORMAT_XML,
        $maxDepth = Serializer::MAX_DEPTH_NOT_SET
    )
    {
        $this->format = $dataFormat;
        $this->maxDepth = $maxDepth;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @inheritdoc
     */
    public function setDepth($maxDepth)
    {
        if (false === is_int($maxDepth)) {
            throw new \LogicException(__CLASS__.'::'.__FUNCTION__.' expects an int but a '.gettype($maxDepth).' was supplied');
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
    abstract public function deserialize($data);

    /**
     * @inheritdoc
     */
    abstract public function serialize($data);

    /**
     * @param string  $variableName
     * @param mixed   $containingClass
     * @return string
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function cleanVariableName($variableName, $containingClass)
    {
        $className = '';

        if (true === is_object($containingClass)) {
            $className = get_class($containingClass);
        } elseif (true === is_array($containingClass)) {
            $className = get_class(array_pop($containingClass));
        }

        $cleanedName = str_replace('*', '', $variableName);
        $cleanedName = str_replace($className, '', $cleanedName);

        return trim($cleanedName);
    }

}
