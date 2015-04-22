# breakfast-serializer

[![Build Status](https://travis-ci.org/brettminnie/breakfast-serializer.svg)](https://travis-ci.org/brettminnie/breakfast-serializer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/brettminnie/breakfast-serializer/?branch=develop)
[![Coverage Status](https://coveralls.io/repos/brettminnie/breakfast-serializer/badge.svg)](https://coveralls.io/r/brettminnie/breakfast-serializer)

A (hopefully) backwards compatible replacement for the other well known serializer

Currently will only support json and do a full depth/breadth recursion, we'll build on this slowly

Example
```php
   
   //To retrieve json of an object
   
   $jsonData = BDBStudios\BreakfastSerializer\Serializer::getSerializer()->serialize($myClass);
   
   
   //To unserialize
   
   $myUnserializedObject = BDBStudios\BreakfastSerializer\Serializer::getSerializer()->deserialize($jsonData);
    
```


