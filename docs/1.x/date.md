# Date helper

## Table of contents

- [timestamp](#timestamp)
- [timezone](#timezone)
- [factory](#factory)
- [sqlFormat](#sqlformat)
- [humanReadable](#humanreadable)
- [isValid](#isvalid)
- [isToday](#istoday)
- [isTomorrow](#istomorrow)
- [isThisWeek](#isthisweek)
- [isThisMonth](#isthismonth)
- [isThisYear](#isthisyear)

## timestamp

Returns the current timestamp or the timestamp of a given date.

```php
use Zaphyr\Utils\Date;


Date::timestamp(); // time()
Date::timestamp(new DateTime('1989-12-19 05:04:00')); // 630047040
Date::timestamp('630047040'); // 630047040
Date::timestamp('yesterday'); // 'yesterday'
```

## timezone

Returns the timezone.

```php
use Zaphyr\Utils\Date;

Date::timezone(new DateTimeZone('UTC')); // \DateTimezone::class
Date::timezone()->getName(); // 'UTC'
Date::timezone('GMT')->getName(); // 'GMT'
```

## factory

Returns a DateTime object.

```php
use Zaphyr\Utils\Date;

Date::factory(); // \DateTime::class
Date::factory('1989-12-19 05:04:00'); // \DateTime::class
```

## sqlFormat

Return a SQL compliant date format.

```php
use Zaphyr\Utils\Date;

Date::sqlFormat(); // 'Y-m-d H:i:s'
Date::sqlFormat(630047040); // '1989-12-19 05:04:00'
Date::sqlFormat('1989-12-19'); // '1989-12-19 00:00:00'
```

## humanReadable

Returns a human-readable date format.

```php
use Zaphyr\Utils\Date;

Date::humanReadable(630047040); // '19 Dec 1989 05:04'
Date::humanReadable('1989-12-19 05:04:00', 'd F Y'); // '19 December 1989'
```

## isValid

Determines whether a given date is valid.

```php
use Zaphyr\Utils\Date;

Date::isValid('630047040'); // true
Date::isValid('now'); // true
Date::isValid('1989-12-19 05:04:00'); // true
Date::isValid(''); // false
```

## isToday

Determines whether a given date is today.

```php
use Zaphyr\Utils\Date;

Date::isToday('+0 day'); // true
```

## isTomorrow

Determines whether a given date is tomorrow.

```php
use Zaphyr\Utils\Date;

Date::isTomorrow('+1 day'); // true
Date::isTomorrow('+0 day'); // false
```

## isThisWeek

Determines whether a given date is this week.

```php
use Zaphyr\Utils\Date;

Date::isThisWeek('+0 week'); // ture
Date::isThisWeek('+1 week'); // false
```

## isThisMonth

Determines whether a given date is this month.

```php
use Zaphyr\Utils\Date;

Date::isThisMonth('+0 month'); // true
Date::isThisMonth('+1 month') // false
```

## isThisYear

Determines whether a given date is this year.

```php
use Zaphyr\Utils\Date;

Date::isThisYear('+0 year'); // true
Date::isThisYear('+1 year'); // false
```
