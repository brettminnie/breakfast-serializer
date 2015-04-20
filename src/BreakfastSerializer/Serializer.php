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
                        $data
                    )
                );

                break;
        }

        return null;
    }


    /**
     * @param      $baseObject
     * @param bool $exposeClassname
     * @return array
     */
    protected function objectToArray($baseObject, $exposeClassname = true)
    {
        $data = array();

        $objAsArray = is_object($baseObject) ? (array)$baseObject : $baseObject;

        foreach ($objAsArray as $key => $val) {
            $val        =
                (is_array($val) || is_object($val)) ? $this->objectToArray($val, $exposeClassname) : $val;
            $data[$this->cleanVariableName($key, $baseObject)] = $val;
        }

        if (true === $exposeClassname && is_object($baseObject)) {
            $data['className'] = get_class($baseObject);
        }

        return $data;
    }

    /**
     * @param string  $variableName
     * @param string  $containingClass
     * @return string
     */
    protected function cleanVariableName($variableName, $containingClass)
    {
        $cleanedName = $className = '';

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
