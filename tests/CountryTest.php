<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Country;

class CountryTest extends TestCase
{
    /* -------------------------------------------------
     * GET NAME BY ISO CODE
     * -------------------------------------------------
     */
    public function testGetNameByIsoCode(): void
    {
        self::assertSame('Germany', Country::getNameByIsoCode('DE'));
    }
    public function testGetNameByIsoCodeReturnsNullOnInvalidIsoCode(): void
    {
        self::assertNull(Country::getNameByIsoCode('INVALID'));
    }

    /* -------------------------------------------------
     * GET ALL COUNTRIES
     * -------------------------------------------------
     */

    public function testGetAllCountries(): void
    {
        self::assertSame(count(Country::getAllCountries()), 239);
    }

    /* -------------------------------------------------
     * GET ALL COUNTRIES AS JSON STRING
     * -------------------------------------------------
     */

    public function  testGetAllCountriesAsJsonString(): void
    {
        self::assertIsString(Country::getAllCountriesAsJsonString());
    }
}
