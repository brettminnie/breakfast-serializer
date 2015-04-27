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

    public function construct()
    {
        $this->propertyOne = __METHOD__;

        $this->propertyTwo = 1;

        $this->internalProperty = uniqid();

        $this->simpleInstance = new SimpleClass();
    }
}