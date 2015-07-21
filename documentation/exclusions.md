# Breakfast Serializer - Excluding Data

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

### Excluding Data

Sometimes you do not wish data to be returned in the serialized object, nor to be reserialized back into it.
We have implemented a simple way to exclude data, this currently works both ways so if a property is excluded, that's it.

Each class that requires properties to be excluded can be set up in a yaml file in the config directory. See 
<<<<<<< HEAD
[exclusions.yml](../config/exclusions/exclusions.yml) for a simple example from our test suite. This is commented out as 
=======
[exclusions.yml](../config/exclusions/exclusions.yml]) for a simple example from our test suite. This is commented out as 
>>>>>>> Updated documents
to not load into an actual running instance of the serializer, but the principle is sound.

```yml

    # This is the section in the configuration array in the serializer in which this resides
    exclusions:
        # ClassName including full namespace
        BDBStudios\BreakfastSerializerTest\Fixtures\ExclusionClass:
            # An array of the properties we do not want to return in the serialized object
            excludeVariables:
              - internalProperty
              - isExcluded

```

These are all loaded during creation time and will be automatically applied by the serialize and deserialize methods.

### Further examples 

See [ExclusionTest](../test/BreakfastSerializer/ExclusionTest.php) for further examples
