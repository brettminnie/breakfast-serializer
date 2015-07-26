<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

use BDBStudios\BreakfastSerializer\Property\IsMappable;
use BDBStudios\BreakfastSerializer\Property\MappableProperty;

class NoConfigMappingClass implements IsMappable
{
    use MappableProperty;

    protected $notSetForMapping;
}
