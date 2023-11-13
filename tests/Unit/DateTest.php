<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use DateTime;
use DateTimeZone;
use Exception;
use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Date;

class DateTest extends TestCase
{
    public function setUp(): void
    {
        date_default_timezone_set('UTC');
    }

    /**
     * ------------------------------------------
     * TIMESTAMP
     * ------------------------------------------
     */

    public function testToTimeStamp(): void
    {
        self::assertEquals(time(), Date::timestamp());
        self::assertEquals(630047040, Date::timestamp(new DateTime('1989-12-19 05:04:00')));
        self::assertEquals(630047040, Date::timestamp('630047040'));
        self::assertEquals(strtotime('yesterday'), Date::timestamp('yesterday'));
    }

    public function testTimestampThrowsExceptionOnInvalidValue(): void
    {
        $this->expectException(Exception::class);

        Date::timestamp('invalid');
    }

    /**
     * ------------------------------------------
     * TIMEZONE
     * ------------------------------------------
     */

    public function testTimezone(): void
    {
        self::assertEquals('UTC', Date::timezone()->getName());
        self::assertInstanceOf(DateTimeZone::class, Date::timezone(new DateTimeZone('UTC')));
        self::assertEquals('GMT', Date::timezone('GMT')->getName());
    }

    /**
     * ------------------------------------------
     * FACTORY
     * ------------------------------------------
     */

    public function testFactory(): void
    {
        self::assertInstanceOf(DateTime::class, Date::factory());
        self::assertInstanceOf(DateTime::class, Date::factory('1989-12-19 05:04:00'));
        self::assertInstanceOf(DateTime::class, Date::factory(time()));

        $datetime = new DateTime();
        self::assertEquals($datetime, Date::factory($datetime));
    }

    /**
     * ------------------------------------------
     * SQL FORMAT
     * ------------------------------------------
     */

    public function testSqlFormat(): void
    {
        $format = Date::SQL_FORMAT;

        self::assertEquals(date($format), Date::sqlFormat());
        self::assertEquals(date($format), Date::sqlFormat(''));
        self::assertEquals(date($format), Date::sqlFormat(0));
        self::assertEquals(date($format), Date::sqlFormat(null));
        self::assertEquals('1989-12-19 05:04:00', Date::sqlFormat('630047040'));
        self::assertEquals('1989-12-19 05:04:00', Date::sqlFormat(630047040));
        self::assertEquals('1989-12-19 05:04:00', Date::sqlFormat('1989-12-19 05:04:00'));
        self::assertEquals('1989-12-19 00:00:00', Date::sqlFormat('1989-12-19'));
    }

    /**
     * ------------------------------------------
     * HUMAN READABLE
     * ------------------------------------------
     */

    public function testHumanReadable(): void
    {
        self::assertEquals('19 Dec 1989 05:04', Date::humanReadable(630047040));
        self::assertEquals('19 Dec 1989 05:04', Date::humanReadable('630047040'));
        self::assertEquals(date('d M Y H:i', strtotime('yesterday')), Date::humanReadable('yesterday'));
        self::assertEquals('19 December 1989', Date::humanReadable('1989-12-19 05:04:00', 'd F Y'));
    }

    /**
     * ------------------------------------------
     * IS VALID
     * ------------------------------------------
     */

    public function testIsValid(): void
    {
        self::assertFalse(Date::isValid(''));
        self::assertFalse(Date::isValid(null));
        self::assertFalse(Date::isValid(false));
        self::assertFalse(Date::isValid('-0100'));
        self::assertTrue(Date::isValid('630047040'));
        self::assertTrue(Date::isValid(630047040));
        self::assertTrue(Date::isValid('now'));
        self::assertTrue(Date::isValid('1989-12-19'));
        self::assertTrue(Date::isValid('1989-12-19 05:04:00'));
    }

    /**
     * ------------------------------------------
     * IS TODAY
     * ------------------------------------------
     */

    public function testIsToday(): void
    {
        self::assertTrue(Date::isToday('+0 day'));
        self::assertFalse(Date::isToday('+2 day'));
        self::assertFalse(Date::isToday('-2 day'));
    }

    /**
     * ------------------------------------------
     * IS TOMORROW
     * ------------------------------------------
     */

    public function testIsTomorrow(): void
    {
        self::assertTrue(Date::isTomorrow('+1 day'));
        self::assertFalse(Date::isTomorrow('+0 day'));
        self::assertFalse(Date::isTomorrow('-1 day'));
    }

    /**
     * ------------------------------------------
     * IS THIS WEEK
     * ------------------------------------------
     */

    public function testIsThisWeek(): void
    {
        self::assertTrue(Date::isThisWeek('+0 week'));
        self::assertFalse(Date::isThisWeek('+1 week'));
        self::assertFalse(Date::isThisWeek('-1 week'));
    }

    /**
     * ------------------------------------------
     * IS THIS MONTH
     * ------------------------------------------
     */

    public function testIsThisMonth(): void
    {
        self::assertTrue(Date::isThisMonth('+0 month'));
        self::assertFalse(Date::isThisMonth('+1 month'));
        self::assertFalse(Date::isThisMonth('-1 month'));
    }

    /**
     * ------------------------------------------
     * IS THIS YEAR
     * ------------------------------------------
     */

    public function testIsThisYear(): void
    {
        self::assertTrue(Date::isThisYear('+0 year'));
        self::assertFalse(Date::isThisYear('+1 year'));
        self::assertFalse(Date::isThisYear('-1 year'));
    }
}
