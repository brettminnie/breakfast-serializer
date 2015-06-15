<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

use BDBStudios\BreakfastSerializer\Property\ConfigurableProperty;
use BDBStudios\BreakfastSerializer\Property\IsConfigurable;

/**
 * Class ConfigurationStub
 * @package BDBStudios\BreakfastSerializerTest\Fixtures
 */
class ConfigurationStub implements IsConfigurable
{
    use ConfigurableProperty;
}
