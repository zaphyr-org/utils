<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use DateTime;
use DateTimeZone;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Timezone
{
    /**
     * @return array<string, string[]>
     */
    public static function getAllTimezones(): array
    {
        $timezones = [];
        $continents = DateTimeZone::listIdentifiers();

        foreach ($continents as $timezone) {
            $timezoneParts = explode('/', $timezone);
            $offset = (new DateTimeZone($timezone))->getOffset(new DateTime());
            $hours = round(abs($offset) / 3600);
            $utc = '(UTC' . ($offset < 0 ? '-' : '+') . sprintf('%02s', $hours) . ':00) ';

            if (isset($timezoneParts[0], $timezoneParts[1])) {
                $key = isset($timezoneParts[2]) ? $timezoneParts[1] . '/' . $timezoneParts[2] : $timezoneParts[1];
                $timezones[$timezoneParts[0]][$key] = $utc . str_replace(
                    ['/', '_'],
                    [' - ', ' '],
                    $timezoneParts[2] ?? $timezoneParts[1]
                );
            }
        }

        return $timezones;
    }

    /**
     * @return string
     */
    public static function getAllTimezonesAsJsonString(): string
    {
        return json_encode(self::getAllTimezones(), JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $continent
     *
     * @return array<string, string>|string[]
     */
    public static function getTimezonesByContinent(string $continent): array
    {
        return self::getAllTimezones()[$continent] ?? [];
    }

    /**
     * @param string $continent
     * @param string $city
     *
     * @return string|null
     */
    public static function getTimezone(string $continent, string $city): string|null
    {
        return self::getTimezonesByContinent($continent)[$city] ?? null;
    }
}
