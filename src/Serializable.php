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
     * @param array $data
     * @param int   $dataFormat
     * @return string
     */
    public function serialize(array $data, $dataFormat = Serializable::FORMAT_JSON);

    /**
     * @param     $data
     * @param int $dataFormat
     * @return mixed
     */
    public function deserialize($data, $dataFormat = Serializable::FORMAT_JSON);
}
