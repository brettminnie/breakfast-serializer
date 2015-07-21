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
            $this->uid = uniqid();
        }
    }
    
    $instance = new SimpleClass;
    
    $serializedInstance = SerializerFactory::getSerializer()->serialize($instance);
    
    echo $serializedInstance;

```

This will render 

```JSON
    
    {
        'name':'SimpleClass Instance',
        'uid' : '<random uid string>',
        'className' : 'SimpleClass'
    }

```

### Deserializing to an object

```php
    
    $serializedInstance = "{
       'name':'SimpleClass Instance',
       'uid' : '<random uid string>',
       'className' : 'SimpleClass'
    }";
    
    
    $classInstance = SerializerFactory::getSerializer()->deserialize($serializedInstance);
    
    echo get_class($classInstance);

```

This will return an instance of SimpleObject and `get_class` will return 'SimpleObject'
