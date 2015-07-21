# Breakfast Serializer - All your morning serial goodness

<nav>
    <span>
        <a href='index.md'>
            Home
        </a>
    </span>
    | 
    <span>
        <a href='examples.md'>
            Examples
        </a>
    </span>
     |
    <span>
        <a href='remapping.md'>
            Remapping Data
        </a>
    </span>
     | 
    <span>
        <a href='exclusions.md'>
            Excluding Data
        </a>
    </span>
</nav>

### Installation

`$ composer require brettminnie/breakfast-serializer`

### Basic Configuration

All configuration is done upon creation through the serializerFactory class, this takes 3 arguments, all of which have 
somewhat sensible defaults.

```php

    // These are mimicking the defaults

    // See IsSerializable for other options
    $serializerFormat = IsSerializable::FORMAT_JSON; 
    // This is -1, any positive number will be honoured for depth traversal
    $maxDepth = IsSerializable::MAX_DEPTH_NOT_SET; 
    // Path to the yaml config files, these are loaded recursively into an array in the Serializer instance
    $configPath = './config'; 
    
    $serializerInstance = SerializerFactory::getSerializer (
        $serializerFormat,
        $maxDepth,
        $configPath
    );
```

The serializer.yml file is not currently used, but at a later stage this will be autoloaded on creation to supply the 
defaults if they are missing from the arguments see #23.
