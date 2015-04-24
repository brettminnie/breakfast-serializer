# breakfast-serializer

[![Build Status](https://travis-ci.org/brettminnie/breakfast-serializer.svg)](https://travis-ci.org/brettminnie/breakfast-serializer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/?branch=develop)
[![Dependency Status](https://www.versioneye.com/user/projects/55378b007f43bcd88900033d/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55378b007f43bcd88900033d)

A (hopefully) backwards compatible replacement for the other well known serializer

Currently will only support json and do a full depth/breadth recursion, we'll build on this slowly

Example
```php
   
   //To retrieve json of an object
   $jsonData = BDBStudios\BreakfastSerializer\SerializerFactory::getSerializer()->serialize($myClass);
   
   
   //To unserialize
   $myUnserializedObject = BDBStudios\BreakfastSerializer\SerializerFactory:::getSerializer()->deserialize($jsonData);
   
   //To serialize an object with a limited depth recursion
   $jsonData = 
      BDBStudios\BreakfastSerializer\SerializerFactory::getSerializer(
         IsSerializable::FORMAT_JSON,
         2
      )
      ->serialize($myClass);
    
```


