<?php

namespace BDBStudios\BreakfastSerializer\Tests;

use BDBStudios\BreakfastSerializer\Serializer;

class Foo {
    protected $var1 = true;
    protected $var2 = 'foo';
    protected $uid;

    public function __construct()
    {
        $this->uid = uniqid();
    }
}

class SimpleContainer {

    const INTERNAL_VALUE = PHP_INT_MAX;

    private $exposeMe;

    protected $name;

    protected $simpleArray;

    protected $uid;

    public function __construct()
    {
        $this->name = 'SimpleContainer Instance';

        $this->uid = uniqid();

        $this->exposeMe = true;

        $this->simpleArray = array();
        $this->simpleArray[] = new Simple();
        $this->simpleArray[] = new Simple();
    }
}

class Simple {
    protected $name;

    protected $uid;

    const FOO = 'Bar';

    public function __construct()
    {
        $this->name = 'SimpleClass Instance';
        $this->uid = uniqid();
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

    public function testSerializeSimpleContainer()
    {
        $test = new SimpleContainer();
        $data = $this->instance->serialize($test);

        $this->assertTrue(is_string($data));
        $decodedData = json_decode($data);
    }
}
