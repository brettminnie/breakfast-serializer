<?php

namespace BDBStudios\BreakfastSerializer;

/**
 * Class JSONSerializer
 * @package BDBStudios\BreakfastSerializer
 */
class JSONSerializer extends Serializer implements IsSerializable, IsDepthTraversable
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
        $data = json_decode($data, true);

        return $this->arrayToObject(
            $data
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
     * @todo refactor this out somewhere once we start implementing in new formats
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
                throw $e;
            }
        }

        return $object;
    }

    /**
     * @param mixed $baseObject
     * @param bool  $exposeClassName
     * @return array
     * @todo refactor this out somewhere once we start implementing in new formats
     */
    protected function objectToArray($baseObject, $exposeClassName = true)
    {

        $data = array();

        if ($this->isWithinBounds()) {
            $this->incrementCurrentDepth();

            $objAsArray = is_object($baseObject) ? (array)$baseObject : $baseObject;

            if (true === SerializerFactory::canIterate($objAsArray)) {
                foreach ($objAsArray as $key => $val) {
                    if (true === is_array($val) || true === is_object($val)) {
                        $val = $this->objectToArray($val, $exposeClassName);
                    }

                    $data[$this->cleanVariableName($key, $baseObject)] = $val;
                }

                if (true === $exposeClassName && is_object($baseObject)) {
                    $data['className'] = get_class($baseObject);
                }
            }

            $this->decrementCurrentDepth();
        }


        return $data;
    }

}
