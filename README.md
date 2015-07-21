# breakfast-serializer

[![Build Status](https://travis-ci.org/brettminnie/breakfast-serializer.svg)](https://travis-ci.org/brettminnie/breakfast-serializer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/?branch=develop)
[![Dependency Status](https://www.versioneye.com/user/projects/55378b007f43bcd88900033d/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55378b007f43bcd88900033d)
[![Coverage Status](https://coveralls.io/repos/brettminnie/breakfast-serializer/badge.svg?branch=master&service=github)](https://coveralls.io/github/brettminnie/breakfast-serializer?branch=master)

A replacement for the other well known serializer, initially we were aiming for backwards compatibility, however it seemed
more appropriate to develop a lightweight alternative. We are forgoing the depth of features now to offer something that is
easy to configure and works well without any configuration.

### Installation

`$ composer require brettminnie/breakfast-serializer` 

Job done, start enjoying your morning serial!

### Configuration

A replacement for the other well known serializer, initially we were aiming for backwards compatibility, however it seemed
more appropriate to develop a lightweight alternative. We are forgoing the depth of features now to offer something that is
easy to configure and works well without any configuration.

### Supported Serialization Formats
- [x] JSON
- [ ] XML
- [ ] PHP Object Notation
- [ ] YAML

### Features
 - [x] Simple limiting of traversal depth
 - [x] Mapping of properties to alternate names and back again
 - [x] Excluding of properties from serialization and ignoring them on deserialization
 - [x] Simple YAML config format (Yay no slow php annotations!)
 
Quick and Dirty Example
```php
   
   // To retrieve the json representation json of an object
    $jsonData = BDBStudios\BreakfastSerializer\SerializerFactory::getSerializer()
        ->serialize($myClass);
   
   // To unserialize
   $myClass = BDBStudios\BreakfastSerializer\SerializerFactory:::getSerializer()
        ->deserialize($jsonData);
   
   //To serialize an object with a limited depth recursion (aka only some of it)
   $jsonData = 
      BDBStudios\BreakfastSerializer\SerializerFactory::getSerializer(
         BDBStudios\BreakfastSerializer\IsSerializable::FORMAT_JSON,
         2
      )
      ->serialize($myClass);
    
```

Further examples in the [documentation](documentation/index.md) directory.


