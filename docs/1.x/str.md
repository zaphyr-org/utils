# String helper

## Table of contents

- [toAscii](#toascii)
- [toArray](#toarray)
- [toBool](#tobool)
- [beginsWith](#beginswith)
- [endsWith](#endswith)
- [contains](#contains)
- [containsAll](#containsall)
- [lower](#lower)
- [lowerFirst](#lowerfirst)
- [upper](#upper)
- [upperFirst](#upperfirst)
- [limit](#limit)
- [limitSafe](#limitsafe)
- [firstPos](#firstpos)
- [lastPos](#lastpos)
- [stripWhitespace](#stripwhitespace)
- [insert](#insert)
- [equals](#equals)
- [length](#length)
- [escape](#escape)
- [title](#title)
- [slug](#slug)
- [studly](#studly)
- [camel](#camel)
- [snake](#snake)

## toAscii

Transliterates a UTF-8 value to ASCII.

```php
use Zaphyr\Utils\Str;

Str::toAscii('Τάχιστη αλώπηξ'); // 'Taxisth alwphx'
```

## toArray

Converts a string to an array.

```php
use Zaphyr\Utils\Str;

Str::toArray('Hello'); // ['H', 'e', 'l', 'l', 'o']
```

## toBool

Returns the boolean representation of a string.

```php
use Zaphyr\Utils\Str;

Str::toBool('true'); // true
Str::toBool('Off'); // false
```

The following strings are converted to a boolean value:

| true      | false     |
|-----------|-----------|
| `"true"`  | `"false"` |
| `1`       | `0`       |
| `"on"`    | `"off"`   |
| `"On"`    | `"Off"`   |
| `"ON"`    | `"OFF"`   |
|           | `"no"`    |
|           | `""`      |

## beginsWith

Determines if the given string starts with a given substring.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::beginsWith('Case sensitive', 'C'); // true
Str::beginsWith('Case sensitive', 'c'); // false

// case insensitive
Str::beginsWith('Case sensitive', 'c', false); // true
```

## endsWith

Determines if a given string ends with a given substring.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::endsWith('Case sensitive', 'e'); // true
Str::endsWith('Case sensitive', 'E'); // false

// case insensitive
Str::endsWith('Case sensitive', 'E', false); // true
```

## contains

Determines if a given string contains a given substring.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::contains('Case sensitive', 'C'); // true
Str::contains('Case sensitive', 'c'); // false

// case insensitive
Str::contains('Case sensitive', 'c', false); // true
```

## containsAll

Determines if a given string contains all array substring.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::containsAll('Case sensitive', ['C', 's']); // true
Str::containsAll('Case sensitive', ['c', 'S']); // false

// case insensitive
Str::containsAll('Case sensitive', ['c', 'S'], false); // true
```

## lower

Converts the given string to lower-case.

```php
use Zaphyr\Utils\Str;

Str::lower('FOO'); // 'foo'
```

## lowerFirst

Converts the first character of a given string to lower-case.

```php
use Zaphyr\Utils\Str;

Str::lowerFirst('FOO'); // 'fOO'
```

## upper

Converts the given string top upper-case.

```php
use Zaphyr\Utils\Str;

Str::upper('foo'); // 'FOO'
```

## upperFirst

Converts the first character of a given string to upper-case.

```php
use Zaphyr\Utils\Str;

Str::upperFirst('foo'); // 'Foo'
```

## limit

Limits the number of characters in a string.

```php
use Zaphyr\Utils\Str;

Str::limit('Foobar', 3); // 'Foo...'
Str::limit('Foobar', 3, ' ->'); // 'Foo ->'
```

## limitSafe

Limits the length of a string, taking into account not cutting words.

```php
use Zaphyr\Utils\Str;

Str::limitSafe('Foo bar', 5); // 'Foo...'
Str::limitSafe('Foo bar', 5, ' ->')); // 'Foo ->'
```

## firstPos

Finds position of first occurrence of string in a string.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::firstPos('Hello World', 'World'); // 6
Str::firstPos('Hello World', 'world'); // false

// offset
Str::firstPos('Hello World, Hello You', 'Hello', 7); // 13

// case insensitive
Str::firstPos('Hello World', 'world', 0, false); // 6
```

## lastPos

Finds position of last occurrence of a string in a string.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::lastPos('Hello World, Hello You', 'Hello'); // 13
Str::lastPos('Hello World, Hello You', 'hello'); // false

// offset
Str::lastPos('Hello World, Hello You', 'Hello', 14); // false

// case insensitive
Str::lastPos('Hello World, Hello You', 'hello', 0, false); // 13
```

## replace

Replaces part of a string by a matching pattern.

```php
use Zaphyr\Utils\Str;

Str::replace('foo', 'f[o]+', 'bar'); // 'bar'
```

## stripWhitespace

Strips all whitespaces from the given string.

```php
use Zaphyr\Utils\Str;

Str::stripWhitespace('Foo bar'); // 'Foobar
```

## insert

Inserts a string inside a string at a given position.

```php
use Zaphyr\Utils\Str;

Str::insert('foo', 'bar', 3); // 'Foobar'
```

## equals

Determines whether two strings are equal.

```php
use Zaphyr\Utils\Str;

// case sensitive
Str::equals('Case sensitive', 'Case sensitive'); // true
Str::equals('Case sensitive', 'case sensitive'); // false

// case insensitive
Str::equals('Case sensitive', 'case sensitive', false); // true
```

## length

Returns the string length.

```php
use Zaphyr\Utils\Str;

Str::length('Foo'); // 3
```

## escape

Escapes a string.

```php
use Zaphyr\Utils\Str;

Str::escape('<h1>Hello world</h1>'); // '&lt;h1&gt;Hello world&lt;/h1&gt;'
```

## title

Converts the given string to title case.

```php
use Zaphyr\Utils\Str;

Str::title('hello world'); // 'Hello World'
```

## slug

Generates a URL friendly "slug" from a given string.

```php
use Zaphyr\Utils\Str;

Str::slug('Hello World'); // 'hello-world'
```

## studly

Converts a value to studly caps case.

```php
use Zaphyr\Utils\Str;

Str::studly('Sho-ebo-x'); // 'ShoEboX'
Str::studly('Sho -_- ebo -_ - x')); // 'ShoEboX'
```

## camel

Converts a value to camel case.

```php
use Zaphyr\Utils\Str;

Str::camel('Hello world-whats up'); // 'helloWorldWhatsUp'
```

## snake

Converts a string to snake case.

```php
use Zaphyr\Utils\Str;

Str::snake('HelloWorld'); // 'hello_world'
```
