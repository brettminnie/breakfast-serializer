<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class Serializer
 * @package BDBStudios
 */
abstract class Serializer implements Serializable
{
    /**
     * @var int
     */
    protected $format;

    /**
     * @param int $dataFormat
     */
    protected function __construct($dataFormat = Serializer::FORMAT_XML)
    {
        $this->format = $dataFormat;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

}
