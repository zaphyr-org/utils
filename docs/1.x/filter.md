# Filter helper

## Table of contents

- [alpha](#alpha)
- [alphanum](#alphanum)
- [base64](#base64)
- [digits](#digits)
- [float](#float)
- [int](#int)

## alpha

Returns only the alpha chars of a string.

```php
use Zaphyr\Utils\Filter;

Filter::alpha('fo-0-o'); // 'foo'
```

## alphanum

Returns only the alphanum chars of a string.

```php
use Zaphyr\Utils\Filter;

Filter::alphanum('foo-* 123'); // 'foo123'
```

## base64

Returns only the base64 chars of a string.

```php
use Zaphyr\Utils\Filter;

Filter::base64('a8O2bGph*c2do ZHZiYX () Nua2zDtmzDpMOkYQ=='); // 'a8O2bGphc2doZHZiYXNua2zDtmzDpMOkYQ=='
```

## digits

Returns only digits of the given string.

```php
use Zaphyr\Utils\Filter;

Filter::digits('f1o2o3'); // 123
```

## float

Smart converts any string to float with round.

```php
use Zaphyr\Utils\Filter;

Filter::float('1.5123', 2); // 1.51
Filter::float('- 1 0'); // -10.0
```

## int

Smart converts any string to int.

```php
use Zaphyr\Utils\Filter;

Filter::int('+3'); // 3
Filter::int('- 1 0'); // -10
```
