<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Timezone;

class TimezoneTest extends TestCase
{
    /* -------------------------------------------------
     * GET ALL TIMEZONES
     * -------------------------------------------------
     */

    public function testGetAllTimezones(): void
    {
        self::assertSame(count(Timezone::getAllTimezones()), 143);
    }
}
