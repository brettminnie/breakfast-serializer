<?php

call_user_func(function() {
    if ( ! is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
        throw new \RuntimeException('Did not find vendor/autoload.php. Did you run "composer install --dev"?');
    }

    $loader = require $autoloadFile;
    $loader->add('BDBStudios\BreakfastSerializerTests', __DIR__);
    $loader->add('BDBStudios\BreakfastSerializerTests\Fixtures', __DIR__ . '/Fixtures');
});
