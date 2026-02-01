<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Zaphyr\Utils\Clock;

class ClockTest extends TestCase
{
    protected ClockInterface $clock;

    protected function setUp(): void
    {
        $this->clock = new Clock();
    }

    protected function tearDown(): void
    {
        unset($this->clock);
    }

    /* -------------------------------------------------
     * NOW
     * -------------------------------------------------
     */

    public function testNow(): void
    {
        self::assertSame((new DateTimeImmutable())->getTimestamp(), $this->clock->now()->getTimestamp());
    }
}
