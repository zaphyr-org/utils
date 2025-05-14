<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Timezone;

class TimezoneTest extends TestCase
{
    /* -------------------------------------------------
     * GET ALL TIMEZONES
     * -------------------------------------------------
     */

    /**
     * @param string $continent
     *
     * @return void
     * @dataProvider continentsDataProvider
     */
    public function testGetAllTimezones(string $continent): void
    {
        self::assertArrayHasKey($continent, Timezone::getAllTimezones());
    }

    /* -------------------------------------------------
     * GET ALL TIMEZONES AS JSON STRING
     * -------------------------------------------------
     */

    public function testGetAllTimezonesAsJsonString(): void
    {
        self::assertIsString(Timezone::getAllTimezonesAsJsonString());
    }

    /* -------------------------------------------------
     * GET TIMEZONES BY CONTINENT
     * -------------------------------------------------
     */

    /**
     * @param string $continent
     *
     * @return void
     * @dataProvider continentsDataProvider
     */
    public function testGetTimezonesByContinent(string $continent): void
    {
        self::assertIsArray(Timezone::getTimezonesByContinent($continent));
    }

    public function testGetTimezonesByContinentReturnsEmptyArrayOnInvalidContinent(): void
    {
        self::assertEmpty(Timezone::getTimezonesByContinent('InvalidContinent'));
    }

    /* -------------------------------------------------
     * GET TIMEZONE
     * -------------------------------------------------
     */

    public function testGetTimezone(): void
    {
        $offset = (new DateTimeZone('Europe/Berlin'))->getOffset(new \DateTime());
        $hours = round(abs($offset) / 3600);
        $timezone = '(UTC' . ($offset < 0 ? '-' : '+') . sprintf('%02s', $hours) . ':00) Berlin';

        self::assertEquals($timezone, Timezone::getTimezone('Europe', 'Berlin'));
    }

    public function testGetTimezoneReturnsNullOnInvalidContinent(): void
    {
        self::assertNull(Timezone::getTimezone('InvalidContinent', 'Berlin'));
    }

    public function testGetTimezoneReturnsNullOnInvalidCity(): void
    {
        self::assertNull(Timezone::getTimezone('Europe', 'InvalidCity'));
    }

    /**
     * @return array<string[]>
     */
    public static function continentsDataProvider(): array
    {
        return [
            ['Africa'],
            ['America'],
            ['Antarctica'],
            ['Arctic'],
            ['Asia'],
            ['Atlantic'],
            ['Australia'],
            ['Europe'],
            ['Indian'],
            ['Pacific'],
        ];
    }
}
