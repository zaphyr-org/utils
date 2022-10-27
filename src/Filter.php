<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Filter
{
    /**
     * @param mixed $value
     *
     * @return string|string[]|null
     */
    public static function alpha($value)
    {
        return preg_replace('#[^[:alpha:]]#', '', $value);
    }

    /**
     * @param mixed $value
     *
     * @return string|string[]|null
     */
    public static function alphanum($value)
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
     * @param mixed $value
     *
     * @return mixed
     */
    public static function digits($value)
    {
        $cleaned = str_replace(['-', '+'], '', $value);

        return filter_var($cleaned, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param mixed $value
     * @param int   $round
     *
     * @return float
     */
    public static function float($value, int $round = 10): float
    {
        $cleaned = preg_replace('#[^\deE\-\.\,]#iu', '', $value);
        $cleaned = str_replace(',', '.', $cleaned);

        if (is_string($cleaned)) {
            preg_match('#[-+]?[\d]+(\.[\d]+)?([eE][-+]?[\d]+)?#', $cleaned, $matches);
        }

        $result = $matches[0] ?? 0.0;

        return round($result, $round);
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public static function int($value): int
    {
        $cleaned = preg_replace('#[^0-9-+.,]#', '', $value);

        preg_match('#[-+]?[\d]+#', $cleaned, $matches);

        $result = $matches[0] ?? 0;

        return (int)$result;
    }
}
