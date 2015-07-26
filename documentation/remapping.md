# Breakfast Serializer - Remapping Data

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

### Remapping Data

Sometimes we may wish to rename a property when being serialized as the returned name may either class with part of the 
api consumer or the consumer may not understand your naming conventions.

Each class that requires properties to be remapped can be set up in a yaml file in the config directory. See 
[mappings.yml](../config/mappings/mappings.yml) for a simple example from our test suite. This is commented out as 
to not load into an actual running instance of the serializer, but the principle is sound.

```yml

    # This is the section in the configuration file that will re-map class variables
    mappings:
        # ClassName to remap including namespace
        BDBStudios\BreakfastSerializerTest\Fixtures\MappingClass:
            # Key Value pairs of the class variables, the key being the class property
            mappedVariables:
                - mappedPropertyOne: 'propertyThree'
                - mappedPropertyTwo: 'propertyFour'

```

These are all loaded during creation time and will be automatically applied by the serialize and deserialize methods.

### Further examples 

See [MappingPropertyTest](../test/BreakfastSerializer/MappingPropertyTest.php) for further examples
