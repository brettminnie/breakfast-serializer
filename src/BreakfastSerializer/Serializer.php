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
     * @inheritdoc
     */
    public static function isIterable($object)
    {
        return (is_array($object) || $object instanceof \Traversable);
    }

    /**
     * @inheritDoc
     */
    public function deserialize($data, $dataFormat = Serializable::FORMAT_JSON)
    {
        if (Serializable::FORMAT_JSON !== $dataFormat) {
            throw new \LogicException('Currently only JSON is supported');
        }

        switch ($dataFormat) {
            case Serializable::FORMAT_JSON:
                $data = json_decode($data, true);
                return $this->arrayToObject(
                    $data
                );
        }
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
            case Serializable::FORMAT_JSON:
                return json_encode(
                    $this->objectToArray(
                        $data
                    )
                );
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    protected function arrayToObject(array $data)
    {
        $object     = new $data['className']();
        $reflection = new \ReflectionClass($data['className']);
        $breadth    = array();

        $object = $this->extractAndSetSingleDepthProperties($data, $breadth, $reflection, $object);
        $object = $this->extractAndSetMultipleDepthProperties($breadth, $reflection, $object);

        return $object;
    }

    /**
     * @param array $data
     * @param array $breadth
     * @param \ReflectionClass $reflection
     * @param mixed $object
     * @return mixed
     * @throws \Exception
     */
    protected function extractAndSetSingleDepthProperties(
        array $data,
        array& $breadth,
        \ReflectionClass& $reflection,
        $object
    )
    {
        foreach($data as $key=>$value) {
            if (true === is_array($value)) {
                $breadth[$key] = $value;
            } else {
                try {
                    $property = $reflection->getProperty($key);
                    $property->setAccessible(true);
                    $property->setValue($object, $value);
                } catch (\ReflectionException $e) {
                    //Non property so we ignore this
                } catch (\Exception $e) {
                    throw $e;
                }
            }
        }

        return $object;
    }

    /**
     * @param array $breadth
     * @param \ReflectionClass $reflection
     * @param mixed $object
     * @return mixed
     * @throws \Exception
     */
    protected function extractAndSetMultipleDepthProperties(
        array& $breadth,
        \ReflectionClass& $reflection,
        $object
    )
    {
        $propertyData = array();
        
        foreach($breadth as $key => $value) {
            foreach ($value as $instance) {
                $propertyData[] = $this->arrayToObject($instance);
            }

            try {
                $property = $reflection->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($object, $propertyData);
            } catch (\ReflectionException $e) {
                //Non property so we ignore this
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return $object;
    }


    /**
     * @param mixed $baseObject
     * @param bool  $exposeClassname
     * @return array
     */
    protected function objectToArray($baseObject, $exposeClassname = true)
    {
        $data = array();

        $objAsArray = is_object($baseObject) ? (array)$baseObject : $baseObject;

        if (true === self::isIterable($objAsArray)) {
            foreach ($objAsArray as $key => $val) {
                $val =
                    (is_array($val) || is_object($val)) ? $this->objectToArray($val, $exposeClassname) : $val;
                $data[$this->cleanVariableName($key, $baseObject)] = $val;
            }

            if (true === $exposeClassname && is_object($baseObject)) {
                $data['className'] = get_class($baseObject);
            }
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
