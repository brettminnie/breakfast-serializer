<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

class ExclusionClass
{
    /** @var  String */
    protected $propertyOne;

    /** @var  int */
    protected $propertyTwo;

    /** @var  int */
    protected $internalProperty;

    /** @var bool  */
    protected $isExcluded = true;

    /** @var  SimpleClass */
    protected $simpleInstance;

    public function __construct()
    {
        $this->propertyOne = __FUNCTION__;

        $this->propertyTwo = 1;

        $this->internalProperty = 'Should not be set';

        $this->simpleInstance = new SimpleClass();
    }
}
