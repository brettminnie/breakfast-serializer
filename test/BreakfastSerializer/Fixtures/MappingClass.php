<?php


namespace BDBStudios\BreakfastSerializerTest\Fixtures;


class MappingClass
{
    /**
     * @var string
     */
    protected $propertyOne;

    /**
     * @var string
     */
    protected $propertyTwo;

    /**
     * @var string
     */
    protected $mappedPropertyOne;

    /**
     * @var string
     */
    protected $mappedPropertyTwo;

    public function __construct()
    {
        $this->propertyOne = '';
        $this->propertyTwo = '';
        $this->mappedPropertyOne = '';
        $this->mappedPropertyTwo = '';
    }

    public function initForTest()
    {
        $this->propertyOne = 'Property One';
        $this->propertyTwo = 'Property Two';
        $this->mappedPropertyOne = 'Mapped property one';
        $this->mappedPropertyTwo = 'Mapped property two';

    }
}
