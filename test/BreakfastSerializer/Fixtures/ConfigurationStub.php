<?php

namespace BDBStudios\BreakfastSerializerTest\Fixtures;

use BDBStudios\BreakfastSerializer\ConfigurableProperty;
use BDBStudios\BreakfastSerializer\IsConfigurable;

/**
 * Class ConfigurationStub
 * @package BDBStudios\BreakfastSerializerTest\Fixtures
 */
class ConfigurationStub implements IsConfigurable
{
    use ConfigurableProperty;
}
