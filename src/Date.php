<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use DateTime;
use DateTimeZone;
use Zaphyr\Utils\Exceptions\UtilsException;

/**
 * Class Date
 *
 * @package Zaphyr\Utils
 * @author  merloxx <merloxx@zaphyr.org>
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
     * @param DateTime|int|string $time
     *
     * @return int
     * @throws UtilsException
     *
     */
    public static function timestamp($time = null): int
    {
        if (!$time) {
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
     * @param DateTimeZone|string $timezone
     *
     * @return DateTimeZone
     */
    public static function timezone($timezone = null): DateTimeZone
    {
        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        $timezone = $timezone ?: date_default_timezone_get();

        return new DateTimeZone($timezone);
    }

    /**
     * @param DateTime|string|null $time
     * @param null                 $timezone
     *
     * @return DateTime
     *
     * @throws UtilsException
     */
    public static function factory($time = null, $timezone = null): DateTime
    {
        $timezone = self::timezone($timezone);

        if ($time instanceof DateTime) {
            return $time->setTimezone($timezone);
        }

        $dateTime = new DateTime('@' . self::timestamp($time));

        return $dateTime->setTimezone($timezone);
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return string
     * @throws UtilsException
     *
     */
    public static function sqlFormat($time = null): string
    {
        return self::factory($time)->format(self::SQL_FORMAT);
    }

    /**
     * @param DateTime|int|string $time
     * @param string              $format
     *
     * @return string
     *
     * @throws UtilsException
     *
     */
    public static function humanReadable($time, string $format = 'd M Y H:i'): string
    {
        return self::factory($time)->format($format);
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isValid($time): bool
    {
        if ($time) {
            return self::timestamp($time) > 0;
        }

        return false;
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isToday($time): bool
    {
        return self::factory($time)->format('Y-m-d') === self::factory()->format('Y-m-d');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isTomorrow($time): bool
    {
        return self::factory($time)->format('Y-m-d') === self::factory('tomorrow')->format('Y-m-d');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isThisWeek($time): bool
    {
        return self::factory($time)->format('W-Y') === self::factory()->format('W-Y');
    }

    /**
     * @param DateTime|int|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isThisMonth($time): bool
    {
        return self::factory($time)->format('m-Y') === self::factory()->format('m-Y');
    }

    /**
     * @param DateTime|string $time
     *
     * @return bool
     * @throws UtilsException
     *
     */
    public static function isThisYear($time): bool
    {
        return self::factory($time)->format('Y') === self::factory()->format('Y');
    }
}
