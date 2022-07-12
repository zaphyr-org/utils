# Math helper

## Table of contents

- [round](#round)
- [average](#average)
- [percentage](#percentage)
- [ordinal](#ordinal)
- [faculty](#faculty)
- [combinations](#combinations)
- [min](#min)
- [max](#max)
- [isInteger](#isinteger)
- [isFloat](#isfloat)
- [isInRange](#isinrange)
- [isOutOfRange](#isoutofrange)
- [isEven](#iseven)
- [isOdd](#isodd)
- [isPositive](#ispositive)
- [isNegative](#isnegative)

## round

Rounds a given number up/down by a given precision.

```php
use Zaphyr\Utils\Math;

Math::round(1.61, 1); // 1.7
Math::round(1.61, 1, Math::ROUND_DOWN); // 1.6
```

## average

Returns the average of a given number array.

```php
use Zaphyr\Utils\Math;

Math::average([1, 3, 5]); // 3.0
```

## percentage

Returns the percentage of a given number.

```php
use Zaphyr\Utils\Math;

$percentage = 40;
$total = 20;

Math::percentage($percentage, $total); // 8
```

## ordinal

Returns the ordinal of a given number.

```php
use Zaphyr\Utils\Math;

Math::ordinal(1); // '1st'
Math::ordinal(2); // '2nd'
Math::ordinal(223); // '223rd'
```

## faculty

Returns the faculty of a given number.

```php
use Zaphyr\Utils\Math;

Math::faculty(10); // 3628800
```

## combinations

Returns all possible combinations of an array of numbers.

**This method can be very slow and should be used with care!**

```php
use Zaphyr\Utils\Math;

Math::combinations([1, 2]); // [1 => [1], 2 => [2], 3 => [1, 2]]
```

## min

Returns the minimum required number.

```php
use Zaphyr\Utils\Math;

Math::min(5, 10); // 10
Math::min(20, 10); // 20
```

## max

Returns the maximum required number.

```php
use Zaphyr\Utils\Math;

Math::max(5, 10); // 5
Math::max(10, 20); // 10
```

## isInteger

Determines whether the given number is an integer.

```php
use Zaphyr\Utils\Math;

Math::isInteger(1); // true
Math::isInteger(1.2); // false
```

## isFloat

Determines whether the given number is a float.

```php
use Zaphyr\Utils\Math;

Math::isFloat(1.2); // true
Math::isFloat('1 '); // false
```

## isInRange

Determines whether the given number is in a given range.

```php
use Zaphyr\Utils\Math;

$number = 50;
$min = 10;
$max = 100;

Math::isInRange($number, $min, $max); // true
Math::isInRange($number, $min, 20); // false
```

## isOutOfRange

Determines whether the given number is out of a given range.

```php
use Zaphyr\Utils\Math;

$number = 50;
$min = 10;
$max = 20;

Math::isOutOfRange($number, $min, $max); // true
Math::isOutOfRange($number, $min, 100); // false
```

## isEven

Determines whether the given number is even.

```php
use Zaphyr\Utils\Math;

Math::isEven(20); // true
Math::isEven(0.5); // true
Math::isEven(21); // false
```

## isOdd

Determines whether the given number is odd.

```php
use Zaphyr\Utils\Math;

Math::isOdd(21); // true;
Math::isOdd(21.25); // true
Math::isOdd(20); // false
```

## isPositive

Determines whether the given number is positive.

```php
use Zaphyr\Utils\Math;

Math::isPositive(1); // true
Math::isPositive(0); // true
Math::isPositive(0, false); // false
Math::isPositive(-1); // false
```

## isNegative

Determines whether the given number is negative.

```php
use Zaphyr\Utils\Math;

Math::isNegative(-1); // true
Math::isNegative(-0.5); // true
Math::isNegative(0); // false
```
