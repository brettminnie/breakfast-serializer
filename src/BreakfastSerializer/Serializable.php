<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class Serializable
 * @package BDBStudios\BreakfastSerializer
 */
interface Serializable
{
    const FORMAT_PHP  = 1;
    const FORMAT_JSON = 2;
    const FORMAT_XML  = 4;
    const FORMAT_YML  = 8;

    /**
     * @param int $dataFormat
     * @return Serializer
     */
    public static function getSerializer($dataFormat = Serializable::FORMAT_JSON);

    /**
     * @param object $data
     * @param int   $dataFormat
     * @return string
     */
    public function serialize($data, $dataFormat = Serializable::FORMAT_JSON);

    /**
     * @param array $data
     * @param int   $dataFormat
     * @return object
     */
    public function deserialize($data, $dataFormat = Serializable::FORMAT_JSON);

    /**
     * Tests to see if the object is an array or implements Traversable
     * @param mixed $object
     * @return boolean
     */
    public static function isIterable($object);
}
