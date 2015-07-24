<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class JSONSerializer
 * @package BDBStudios\BreakfastSerializer
 */
class JSONSerializer extends Serializer
{

    /**
     * @param int    $maxDepth
     * @param string $configurationPath
     */
    public function __construct(
        $maxDepth = self::MAX_DEPTH_NOT_SET,
        $configurationPath = ''
    )
    {
        parent::__construct(self::FORMAT_JSON, $maxDepth, $configurationPath);
    }

    /**
     * @inheritdoc
     */
    public function deserialize($data)
    {
        if (true === is_string($data)) {
            $arrayData = json_decode($data, true);
        } else {
            throw new \LogicException('Unsupported data type: String expected however ' . gettype($data) . ' received');
        }

        return $this->arrayToObject(
            $arrayData
        );
    }

    /**
     * @inheritdoc
     */
    public function serialize($data)
    {
        return json_encode(
            $this->objectToArray(
                $data
            )
        );
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * @todo refactor this out somewhere once we start implementing in new formats
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
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function extractAndSetSingleDepthProperties(
        array $data,
        array& $breadth,
        \ReflectionClass& $reflection,
        $object
    )
    {
        foreach ($this->remapArrayKeys($data, $object) as $key=>$value) {

            if (true === is_array($value) && false === array_key_exists('className', $value)) {
                $breadth[$key] = $value;
            } else {
                try {
                    $property = $reflection->getProperty($key);
                    $property->setAccessible(true);
                    if (is_array($value) && true === array_key_exists('className', $value)) {
                        $value = $this->arrayToObject($value);
                    }
                    $property->setValue($object, $value);
                } catch (\ReflectionException $e) {
                    // Non property so we ignore this will bubble anything else
                }
            }
        }

        return $object;
    }

    /**
     * @param array $data
     * @param       $object
     * @return array
     */
    protected function remapArrayKeys(array $data, $object)
    {
        $remappedData = array();

        foreach ($data as $key=>$value) {
            if (true === $this->isPropertyMapped($key, get_class($object), $this->getConfiguration())) {
                $newKey = $this->remapProperty($key, get_class($object), $this->getConfiguration());
            } else {
                $newKey = $key;
            }
            $remappedData[$newKey] = $value;
        }
        return $remappedData;
    }

    /**
     * @param array $breadth
     * @param \ReflectionClass $reflection
     * @param mixed $object
     * @return mixed
     * @throws \Exception
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function extractAndSetMultipleDepthProperties(
        array& $breadth,
        \ReflectionClass& $reflection,
        $object
    )
    {
        $propertyData = array();

        foreach ($breadth as $key => $value) {
            foreach ($value as $instanceKey => $instanceData) {
                if (true === is_array($instanceData)) {
                    $propertyData[$instanceKey] = $this->arrayToObject($instanceData);
                } else {
                    $propertyData[$instanceKey] = $instanceData;
                }
            }

            try {
                $property = $reflection->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($object, $propertyData);
            } catch (\ReflectionException $e) {
                // Non property so we ignore this will bubble anything else
            }
        }

        return $object;
    }

    /**
     * @param mixed $baseObject
     * @param bool  $exposeClassName
     * @return array
     *
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function objectToArray($baseObject, $exposeClassName = true)
    {
        $currentClassName = '';
        $data = array();

        if (false === is_array($baseObject)) {
            $currentClassName = get_class($baseObject);
        }

        if ($this->isWithinBounds()) {
            $this->incrementCurrentDepth();

            $objAsArray = is_object($baseObject) ? (array)$baseObject : $baseObject;

            if (true === SerializerFactory::canIterate($objAsArray)) {
                $this->iterateClassProperties(
                    $objAsArray,
                    $data,
                    $exposeClassName,
                    $baseObject,
                    $currentClassName
                );
            }

            $this->decrementCurrentDepth();
        }

        return $data;
    }

    /**
     * @param array  $objAsArray
     * @param array  $data
     * @param bool   $exposeClassName
     * @param object $baseObject
     * @param string $currentClassName
     *
     * @internal
     * @todo Look at param count and possibly refactor
     */
    protected function iterateClassProperties(
        array $objAsArray,
        array& $data,
        $exposeClassName,
        $baseObject,
        $currentClassName
    )
    {
        foreach ($objAsArray as $key => $val) {
            if (true === is_array($val) || true === is_object($val)) {
                $val = $this->objectToArray($val, $exposeClassName);
            }

            $this->SanitizeAndMapProperty($data, $baseObject, $currentClassName, $key, $val);
        }

        if (true === $exposeClassName && is_object($baseObject)) {
            $data['className'] = get_class($baseObject);
        }
    }
}
