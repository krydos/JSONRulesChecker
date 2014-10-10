[![Build Status](https://travis-ci.org/KryDos/JSONRulesChecker.svg?branch=master)](https://travis-ci.org/KryDos/JSONRulesChecker)
JSONRulesChecker
=======================
This is small library for validation JSON objects in PHP (via regex). You can describe required attributes and check it on requred values.

INSTALLATION
------------
Please update your composer.json. Add this to your **require** section
```
"krydos/json-rules-checker":"dev-master"
```

WHY DO I NEED THIS
-------------

Very often I have a code like this:
```php
try {
    $json = json_decode(getJsonStringFromAnyPlace());

    if(isset($json->attr1)) {
        // do something with $json->attr1
        
        if(isset($json->attr2)) {
            //do something with $json->attr2
        }
        else {
            throw new Exception('attr2 required');
        }
    }
    else {
        throw new Exception('attr1 required');
    }
}
catch(Exception $e) {
    // do something
}
```
I really don't like it. I wrote this library because I want to validate JSON using some rules.

Like that:
```php
try {
    $json = json_deocde(getJsonStringFromAnyPlace());
    // let's imagine that JSON looks something like this:
    // {"root":{"attr1":"value1", "attr2":"value2", "attr3":{"attr3_1":"123"}}}
    
    // let's write a rules
    $rules = array(
        'root' => array(
            'attr1' => '/^value1$/',
            'attr2' => '', // if you don't care what value has this attribute 
                           // then just use empty string
            'attr3' => array(
                'attr3_1'=>'/^\d+$/' // just use regex for value validating
            )
        )
    );
    
    $validation_result = \JSONRulesChecker\JSONChecker::checkJSON($json, $rules); // return true
    if(!$validation_result) {
        throw new Excpetion('Please check you params');
    }
}
catch(Exception $e) {
    //do something
}
```

I like it :)

So, how to use it
-----------------
- create a JSON object via json\_decode() or other functions
- describe rules for your JSON object (just a PHP array as you can see above)
- call the rules checker and pass your JSON object and rules into checker like that:
```php
\JSONRulesChecker\JSONChecker::checkJSON($json, $rules);
```
- by default checker expects that you described only required attributes in the rules array. This means 
that matching are not strict. For example if you JSON object has 3 keys but your rules array has only 2 (which matches with JSON) then 
checker will return **true**.
So if you want to use **STRICT matching** then you can pass **true** as third parameter into checkJSON() function like this:
```php
\JSONRulesChecker\JSONChecker::checkJSON($json, $rules, true);
```

Thanks
------

[@Sbrilenko][1] - for regex idea


  [1]: https://github.com/Sbrilenko


Please feel free to Pull Requests

<3
