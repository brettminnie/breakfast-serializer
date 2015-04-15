<?php

namespace BDBStudios\BreakfastSerializer\Tests;

use BDBStudios\BreakfastSerializer\Serializer;

class Foo {
    protected $var1 = true;
    protected $var2 = foo;
    protected $uid;

    public function __construct()
    {
        $this->uid = uniqid();
    }
}

class Bar {
    protected $foo;

    public function __construct()
    {
        $foo = array();
        $foo[] = new Foo();
        $foo[] = new Foo();
    }
}
class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer
     */
    protected $instance;

    public function setUp()
    {
        $this->instance = Serializer::getSerializer();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->instance instanceof Serializer);
    }

    public function testSerialize()
    {
        $test = new Bar;
        $data = $this->instance->serialize($test);

        var_dump($data);die;
    }
}
