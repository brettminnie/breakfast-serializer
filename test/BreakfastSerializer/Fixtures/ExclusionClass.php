<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

class ExclusionClass
{
    /** @var  string */
    protected $propertyOne;

    /** @var  int */
    protected $propertyTwo;

    /** @var  string */
    protected $internalProperty;

    /** @var bool  */
    protected $isExcluded;

    /** @var  SimpleClass */
    protected $simpleInstance;

    public function __construct()
    {
        $this->propertyOne = __FUNCTION__;

        $this->propertyTwo = 1;

        $this->simpleInstance = new SimpleClass();
    }

    public function initForTest()
    {
        $this->isExcluded = true;
        $this->internalProperty = 'Should not be set';
    }

    public function __get($name)
    {
        if (property_exists(get_class($this), $name)) {
            return $this->{$name};
        }
    }
}
