<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use DateTime;
use DateTimeZone;
use Zaphyr\Utils\Exceptions\UtilsException;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Date
{
    /**
     * @const int
     */
    public const MINUTE = 60;

    /**
     * @const int
     */
    public const HOUR = 3600;

    /**
     * @const int
     */
    public const DAY = 86400;

    /**
     * @const int
     */
    public const WEEK = 604800;

    /**
     * @const int
     */
    public const MONTH = 2592000;

    /**
     * @const int
     */
    public const YEAR = 31536000;

    /**
     * @const string
     */
    public const SQL_FORMAT = 'Y-m-d H:i:s';

    /**
     * @const string
     */
    public const SQL_NULL = '0000-00-00 00:00:00';

    /**
     * @param DateTime|int|string|null $time
     *
     * @throws UtilsException
     * @return int
     */
    public static function timestamp(DateTime|int|string|null $time = null): int
    {
        if (empty($time)) {
            return time();
        }

        if ($time instanceof DateTime) {
            return (int)$time->format('U');
        }

        if (!is_numeric($time)) {
            $time = strtotime($time);

            if (!$time) {
                throw new UtilsException('Could not convert the given value to a timestamp');
            }
        }

        return (int)$time;
    }

    /**
     * @param DateTimeZone|string|null $timezone
     *
     * @return DateTimeZone
     */
    public static function timezone(DateTimeZone|string|null $timezone = null): DateTimeZone
    {
        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        $timezone = !empty($timezone) ? $timezone : date_default_timezone_get();

        return new DateTimeZone($timezone);
    }

    /**
     * @param DateTime|int|string|null $time
     * @param DateTimeZone|string|null $timezone
     *
     * @throws UtilsException
     * @return DateTime
     *
     */
    public static function factory(
        DateTime|int|string|null $time = null,
        DateTimeZone|string|null $timezone = null
    ): DateTime {
        $timezone = self::timezone($timezone);

        if ($time instanceof DateTime) {
            return $time->setTimezone($timezone);
        }

        $dateTime = new DateTime('@' . self::timestamp($time));

        return $dateTime->setTimezone($timezone);
    }

    /**
     * @param DateTime|int|string|null $time
     *
     * @throws UtilsException
     *
     * @return string
     */
    public static function sqlFormat(DateTime|int|string|null $time = null): string
    {
        return self::factory($time)->format(self::SQL_FORMAT);
    }

    /**
     * @param DateTime|int|string $time
     * @param string              $format
     *
     * @throws UtilsException
     *
     * @return string
     *
     */
    public static function humanReadable(DateTime|int|string $time, string $format = 'd M Y H:i'): string
    {
        return self::factory($time)->format($format);
    }

    /**
     * @param mixed $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isValid(mixed $time): bool
    {
        if ($time) {
            return self::timestamp($time) > 0;
        }

        return false;
    }

    /**
     * @param DateTime|int|string $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isToday(DateTime|int|string $time): bool
    {
        return self::factory($time)->format('Y-m-d') === self::factory()->format('Y-m-d');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isTomorrow(DateTime|int|string $time): bool
    {
        return self::factory($time)->format('Y-m-d') === self::factory('tomorrow')->format('Y-m-d');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isThisWeek(DateTime|int|string $time): bool
    {
        return self::factory($time)->format('W-Y') === self::factory()->format('W-Y');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isThisMonth(DateTime|int|string $time): bool
    {
        return self::factory($time)->format('m-Y') === self::factory()->format('m-Y');
    }

    /**
     * @param DateTime|string $time
     *
     * @throws UtilsException
     *
     * @return bool
     */
    public static function isThisYear(DateTime|string $time): bool
    {
        return self::factory($time)->format('Y') === self::factory()->format('Y');
    }
}
