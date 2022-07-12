<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Country;

class CountryTest extends TestCase
{
    /* -------------------------------------------------
     * GET ALL COUNTRIES
     * -------------------------------------------------
     */

    public function testGetAllCountries(): void
    {
        self::assertSame(count(Country::getAllCountries()), 242);
    }
}
