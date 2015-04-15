<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class Serializer
 * @package BDBStudios
 */
class Serializer implements Serializable
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

    /**
     * @param int $dataFormat
     * @return Serializer
     */
    public static function getSerializer($dataFormat = Serializable::FORMAT_JSON)
    {
        $instance = new self($dataFormat = Serializable::FORMAT_JSON);

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function deserialize(array $data, $dataFormat = Serializable::FORMAT_JSON)
    {
        return null;
    }

    /**
     * @param object $data
     * @param int $dataFormat
     * @return mixed
     */
    public function serialize($data, $dataFormat = Serializable::FORMAT_JSON)
    {
        if (Serializable::FORMAT_JSON !== $dataFormat) {
            throw new \LogicException('Currently only JSON is supported');
        }

        switch ($dataFormat) {
            case Serializable::FORMAT_JSON :

                return json_encode(
                    $this->objectToArray(
                        true,
                        $data
                    )
                );

                break;
        }

        return null;
    }


    /**
     * @param bool $exposeClassname
     * @param null $baseObject
     * @return array
     */
    protected function objectToArray($exposeClassname = false, $baseObject = null)
    {
        $data = array();
        $baseObject = (is_null($baseObject)) ? $this : $baseObject;
        $objAsArray = is_object($baseObject) ? get_object_vars($baseObject) : $baseObject;

        foreach ($objAsArray as $key => $val) {
            $val        =
                (is_array($val) || is_object($val)) ? $this->objectToArray($exposeClassname, $val) : $val;
            $data[$key] = $val;
        }

        if (true === $exposeClassname) {
            $data['className'] = get_class($baseObject);
        }

        return $data;
    }



}
