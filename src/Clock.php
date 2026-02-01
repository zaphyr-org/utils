<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Clock implements ClockInterface
{
    /**
     * {@inheritdoc}
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
