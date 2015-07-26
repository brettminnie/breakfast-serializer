<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

class ComplexClass extends SimpleClass
{
    /**
     * @var array
     */
    protected $dataStore;

    /**
     * @var
     */
    protected $numArray;

    /**
     * @var
     */
    protected $assocArray;

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

        for ($i=0; $i<5; ++$i) {
            $this->assocArray['position_' . $i] = $i;
            $this->numArray[] = $i;
        }
    }
}
