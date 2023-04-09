<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use voku\helper\ASCII;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Str
{
    /**
     * @const string
     */
    public const ENCODING = 'UTF-8';

    /**
     * @param string $string
     * @param string $language
     *
     * @return string
     */
    public static function toAscii(string $string, string $language = ASCII::ENGLISH_LANGUAGE_CODE): string
    {
        // @phpstan-ignore-next-line
        return ASCII::to_ascii($string, $language);
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public static function isAscii(string $string): bool
    {
        return ASCII::is_ascii($string);
    }

    /**
     * @param string $string
     *
     * @return array<mixed>
     */
    public static function toArray(string $string): array
    {
        return preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public static function toBool(string $string): bool
    {
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param string          $haystack
     * @param string|string[] $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function beginsWith(string $haystack, array|string $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && static::stringPos($haystack, $needle, 0, $caseSensitive) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string          $haystack
     * @param string|string[] $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function endsWith(string $haystack, array|string $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            if (
                $needle !== '' && static::stringPos(
                    $haystack,
                    $needle,
                    -static::length($needle),
                    $caseSensitive
                ) !== false
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string          $haystack
     * @param string|string[] $needles
     * @param bool            $caseSensitive
     *
     * @return bool
     */
    public static function contains(string $haystack, array|string $needles, bool $caseSensitive = true): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && static::stringPos($haystack, $needle, 0, $caseSensitive) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string   $haystack
     * @param string[] $needles
     * @param bool     $caseSensitive
     *
     * @return bool
     */
    public static function containsAll(string $haystack, array $needles, bool $caseSensitive = true): bool
    {
        foreach ($needles as $needle) {
            if (!static::contains($haystack, $needle, $caseSensitive)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lower(string $string): string
    {
        return mb_strtolower($string, static::ENCODING);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lowerFirst(string $string): string
    {
        $first = static::subString($string, 0, 1);

        return static::lower($first) . static::subString($string, 1);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function upper(string $string): string
    {
        return mb_strtoupper($string, static::ENCODING);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function upperFirst(string $string): string
    {
        $first = static::subString($string, 0, 1);

        return static::upper($first) . static::subString($string, 1);
    }

    /**
     * @param string $string
     * @param int    $length
     * @param string $append
     *
     * @return string
     */
    public static function limit(string $string, int $length = 150, string $append = '...'): string
    {
        if ($length >= static::length($string)) {
            return $string;
        }

        return static::subString($string, 0, $length) . $append;
    }

    /**
     * @param string $string
     * @param int    $length
     * @param string $append
     *
     * @return string
     */
    public static function limitSafe(string $string, int $length = 150, string $append = '...'): string
    {
        if ($length >= static::length($string)) {
            return $string;
        }

        $string = static::subString($string, 0, $length + 1);

        return static::subString($string, 0, static::lastPos($string, ' ')) . $append;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function firstPos(
        string $haystack,
        string $needle,
        int $offset = 0,
        bool $caseSensitive = true
    ): bool|int {
        if ($needle === '') {
            return false;
        }

        return static::stringPos($haystack, $needle, $offset, $caseSensitive);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function lastPos(
        string $haystack,
        string $needle,
        int $offset = 0,
        bool $caseSensitive = true
    ): bool|int {
        return static::stringPosReverse($haystack, $needle, $offset, $caseSensitive);
    }

    /**
     * @param string $string
     * @param string $pattern
     * @param string $replacement
     * @param string $option
     *
     * @return string|null
     */
    public static function replace(
        string $string,
        string $pattern,
        string $replacement,
        string $option = 'msr'
    ): ?string {
        mb_regex_encoding(static::ENCODING);

        $result = mb_ereg_replace($pattern, $replacement, $string, $option);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string $string
     *
     * @return string|null
     */
    public static function stripWhitespace(string $string): ?string
    {
        return static::replace($string, '\s', '');
    }

    /**
     * @param string $string
     * @param string $substring
     * @param int    $index
     *
     * @return string
     */
    public static function insert(string $string, string $substring, int $index): string
    {
        $length = static::length($string);

        if ($length < $index) {
            return $string;
        }

        $start = static::subString($string, 0, $index);
        $end = static::subString($string, $index, $length);

        return $start . $substring . $end;
    }

    /**
     * @param string $string1
     * @param string $string2
     * @param bool   $caseSensitive
     *
     * @return bool
     */
    public static function equals(string $string1, string $string2, bool $caseSensitive = true): bool
    {
        if ($caseSensitive) {
            return $string1 === $string2;
        }

        return static::lower($string1) === static::lower($string2);
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function length(string $string): int
    {
        return mb_strlen($string, static::ENCODING);
    }

    /**
     * @param string $string
     * @param int    $flag
     * @param bool   $doubleEncode
     *
     * @return string
     */
    public static function escape(
        string $string,
        int $flag = ENT_COMPAT,
        bool $doubleEncode = true
    ): string {
        return htmlspecialchars($string, $flag, static::ENCODING, $doubleEncode);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function title(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, static::ENCODING);
    }

    /**
     * @param string $string
     * @param string $delimiter
     * @param string $language
     *
     * @return string
     */
    public static function slug(string $string, string $delimiter = '-', string $language = 'en'): string
    {
        // Transliterate string
        $slug = static::toAscii($string, $language);

        // Replace non letters or digits with $delimiter
        $slug = (string)preg_replace('/[^A-Za-z0-9-]+/', $delimiter, $slug);

        // Remove $delimiter before and after string
        $slug = trim($slug, $delimiter);

        // Remove duplicate $delimiter
        $slug = (string)preg_replace('~' . $delimiter . '+~', $delimiter, $slug);

        // Lowercase string
        return static::lower($slug);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function studly(string $string): string
    {
        $string = (string)static::replace($string, '[-_\s]+', ' ');
        $string = static::title($string);

        return str_replace(' ', '', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function camel(string $string): string
    {
        $string = static::studly($string);

        return static::lowerFirst($string);
    }

    /**
     * @param string $string
     * @param string $delimiter
     *
     * @return string|null
     */
    public static function snake(string $string, string $delimiter = '_'): ?string
    {
        $string = (string)static::replace($string, '\B([A-Z])', '-\1');
        $string = static::lower($string);

        return static::replace($string, '[-_\s]+', $delimiter);
    }

    /**
     * @param string   $string
     * @param int      $start
     * @param int|null $length
     *
     * @return string
     */
    public static function subString(string $string, int $start, int $length = null): string
    {
        return mb_substr($string, $start, $length, static::ENCODING);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function stringPos(
        string $haystack,
        string $needle,
        int $offset = 0,
        bool $caseSensitive = true
    ): bool|int {
        if ($caseSensitive) {
            return mb_strpos($haystack, $needle, $offset, static::ENCODING);
        }

        return mb_stripos($haystack, $needle, $offset, static::ENCODING);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int    $offset
     * @param bool   $caseSensitive
     *
     * @return bool|int
     */
    public static function stringPosReverse(
        string $haystack,
        string $needle,
        int $offset = 0,
        bool $caseSensitive = true
    ): bool|int {
        if ($caseSensitive) {
            return mb_strrpos($haystack, $needle, $offset, static::ENCODING);
        }

        return mb_strripos($haystack, $needle, $offset, static::ENCODING);
    }
}
