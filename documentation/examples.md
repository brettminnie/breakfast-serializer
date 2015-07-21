# Breakfast Serializer - Examples

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

### Serialization of an object

```php

    class SimpleClass
    {
        /**
         * @var string
         */
        protected $name;
    
        /**
         * @var string
         */
        protected $uid;
    
        public function __construct()
        {
            $this->name = 'SimpleClass Instance';
            $this->uid = 'SimpleClassInstance00001';
        }
    }
    
    $instance = new SimpleClass;
    
    $serializedInstance = SerializerFactory::getSerializer()->serialize($instance);
    
    echo $serializedInstance;

```

This will render 

```javascript
    
    {
        'name':'SimpleClass Instance',
        'uid' : 'SimpleClassInstance00001',
        'className' : 'SimpleClass'
    }

```

### Deserializing to an object

```php
    
    $serializedInstance = "{
       'name':'SimpleClass Instance',
       'uid' : 'SimpleClassInstance00001',
       'className' : 'SimpleClass'
    }";
    
    
    $classInstance = SerializerFactory::getSerializer()->deserialize($serializedInstance);
    
    echo get_class($classInstance);

```

This will return an instance of SimpleObject and `get_class` will return 'SimpleObject'


### Getting a new serializer

The serializer is cached by default and will return the same configured instance. To change settings and get a new 
instance of the serializer is quite a simple operation.

```php

    $serializer = SerializerFactory::getSerializer();
    
    // Do our serialization tasks
    ...   
    
    // Now we want a new instance of the serializer with a limited depth recursion
    // We call destroy to uncache the current instance
    SerializerFactory::destroySerializer(); 
    
    $newSerializer = SerializerFactory::getSerializer(
        
    );
    
```
