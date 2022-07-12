# Array helper

## Table of contents

- [accessible](#accessible)
- [exists](#exists)
- [set](#set)
- [add](#add)
- [get](#get)
- [first](#first)
- [last](#last)
- [has](#has)
- [where](#where)
- [only](#only)
- [forget](#forget)
- [except](#except)

## accessible

Determines whether the given value is an array.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar']];

Arr::accessible($array); // true
```

## exists

Determines if the given key exists in the provided array.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar']];

Arr::exists($array, 'foo'); // true
```

## set

Sets an array item to a given value using "dot" notation.
If no key is given to the method, the entire array will be replaced.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar']];

Arr::set($array, 'foo', 'baz'); // ['foo' => 'baz']
Arr::set($array, 'baz', 'qux'); // ['foo' => ['bar'], 'baz' => 'qux']
Arr::set($array, 'bar.baz', 'QUX'); // ['foo' => ['bar'], 'bar' => ['baz' => 'QUX']]
Arr::set($array, ['bar' => 'BAR', 'baz' => 'BAZ']) // ['bar' => 'BAR', 'baz' => 'BAZ']
```

## add

Adds an element to an array using "dot" notation if the given key doesn't exist.
The `add` method will not overwrite existing keys!

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar']];

Arr::add($array, 'baz', 'qux'); // ['foo' => ['bar'], 'baz' => 'qux']
Arr::add($array, 'foo', 'BAR'); // ['foo' => ['bar']]
```

## get

Returns an item from an array using "dot" notation.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar' => 'baz']];

Arr::get($array, 'foo.bar'); // 'baz'
```

The `get()` method also accepts a default value, which will be returned if the specified key is not found.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar' => 'baz']];

Arr::get($array, 'foo.qux', 'qux');
```

## first

Returns the first element in an array passing a given truth test.

```php
use Zaphyr\Utils\Arr;

$array = [100, 200, 300];

Arr::first($array, function ($value, $key) {
    return $value <= 150;
})) // 100
```

A default value may also be passed as the third parameter to the method.
This value will be returned if no value passes the truth test.


```php
use Zaphyr\Utils\Arr;

$array = [100, 200, 300];

Arr::first($array, function ($value, $key) {
    return $value <= 50;
}, 100) // 100
```

## last

Returns the last element in an array passing a given truth test.

```php
use Zaphyr\Utils\Arr;

$array = [100, 200, 300];

Arr::last($array, function ($value, $key) {
    return $value >= 150;
}); // 300
```

A default value may be passed as the third argument to the method.
This value will be returned if no value passes the truth test.

```php
use Zaphyr\Utils\Arr;

$array = [100, 200, 300];

Arr::last($array, function ($value, $key) {
    return $value >= 400;
}, 400); // 400
```

## has

Checks if an item or items exist in an array using "dot" notation.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => ['bar' => 'baz'], 'qux'];

Arr::has($array, 'foo.bar'); // true
```

## where

Filters an array using the given callback.

```php
use Zaphyr\Utils\Arr;

$array = [100, '200', 300];

Arr::where($array, function ($value, $key) {
    return is_string($value);
}); // ['200']
```

## only

Returns a subset of the items from the given array.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => 'bar', 'baz' => 'qux', 'quu' => 'qaa'];

Arr::only($array, ['foo', 'quu']); // ['foo' => 'bar', 'quu' => 'qaa']
```

## forget

Removes one or many array items from a given array using "dot" notation.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => 'bar', 'baz' => 'qux', 'quu' => 'qaa'];

Arr::forget($array, ['baz', 'quu']);

$array; // ['foo' => 'bar']
```

## except

Returns all the given array elements except for a specified array of keys.

```php
use Zaphyr\Utils\Arr;

$array = ['foo' => 'bar', 'baz' => 'qux', 'quu' => 'qaa'];

Arr::except($array, ['foo', 'quu']); // ['baz' => 'qux']
```
