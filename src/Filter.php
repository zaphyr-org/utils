<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Filter
{
    /**
     * @param string|string[] $value
     *
     * @return string|string[]|null
     */
    public static function alpha(string|array $value): string|array|null
    {
        return preg_replace('#[^[:alpha:]]#', '', $value);
    }

    /**
     * @param string|string[] $value
     *
     * @return string|string[]|null
     */
    public static function alphanum(string|array $value): string|array|null
    {
        return preg_replace('#[^[:alnum:]]#', '', $value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function base64(string $value): string
    {
        return (string)preg_replace('#[^A-Z0-9\/+=]#i', '', $value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function digits(string $value): string
    {
        $cleaned = str_replace(['-', '+'], '', $value);

        return (string)filter_var($cleaned, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param mixed $value
     * @param int   $round
     *
     * @return float
     */
    public static function float(mixed $value, int $round = 10): float
    {
        $cleaned = (string)preg_replace('#[^\deE\-\.\,]#iu', '', (string)$value);
        $cleaned = str_replace(',', '.', $cleaned);

        if (is_string($cleaned)) {
            preg_match('#[-+]?\d+(\.\d+)?([eE][-+]?\d+)?#', $cleaned, $matches);
        }

        $result = $matches[0] ?? 0.0;

        return round((float)$result, $round);
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public static function int(mixed $value): int
    {
        $cleaned = (string)preg_replace('#[^0-9-+.,]#', '', (string)$value);

        preg_match('#[-+]?\d+#', $cleaned, $matches);

        $result = $matches[0] ?? 0;

        return (int)$result;
    }
}
