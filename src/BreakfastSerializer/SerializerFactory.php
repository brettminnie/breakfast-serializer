<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class SerializerFactory
 * @package BDBStudios\BreakfastSerializer
 */
class SerializerFactory
{
    /**
     * @var Serializer
     */
    protected static $serializerInstance = null;

    /**
     * Builds an instance of a serializer if the internal instance is null
     * @param int $dataFormat
     * @return Serializer
     */
    public static function getSerializer($dataFormat = IsSerializable::FORMAT_JSON)
    {
        if (null === self::$serializerInstance) {
            $instance = null;

            switch ($dataFormat) {
                case IsSerializable::FORMAT_JSON:
                    $instance = new JSONSerializer();
                    break;
                default:
                    throw new \LogicException('An unsupported serializer type was requested');
            }

            self::$serializerInstance = $instance;
        }

        return self::$serializerInstance;
    }

    /**
     * Tests to see if we can iterate over the object
     * @param mixed $object
     * @return bool
     */
    public static function canIterate($object)
    {
        return (is_array($object) || $object instanceof \Traversable);
    }

    /**
     * Destroys our current serializer so we can build a new one
     */
    public static function destroySerializer()
    {
        if (null !== self::$serializerInstance) {
            self::$serializerInstance = null;
        }
    }

}
