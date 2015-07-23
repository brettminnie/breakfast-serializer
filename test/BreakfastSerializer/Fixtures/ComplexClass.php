<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

class ComplexClass extends SimpleClass
{
    /**
     * @var array
     */
    protected $dataStore;

    public function __construct()
    {
        parent::__construct();

        $this->name = 'Complex Class Instance';

        $this->dataStore = array(
            'foo',
            1,
            'dateInfo'  => new \DateTime(),
            'classInfo' => new SimpleClass()
        );
    }
}
