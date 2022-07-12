<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * Class Math
 *
 * @package Zaphyr\Utils
 * @author  merloxx <merloxx@zaphyr.org>
 */
class Math
{
    /**
     * @const string
     */
    public const ROUND_UP = 1;

    /**
     * @const string
     */
    public const ROUND_DOWN = 2;

    /**
     * @param numeric $number
     * @param int     $precision
     * @param int     $mode (MathHelper::ROUND_UP, MathHelper::ROUND_DOWN)
     *
     * @return bool|float|int
     */
    public static function round($number, int $precision = 2, int $mode = self::ROUND_UP)
    {
        if (!static::isFloat($number)) {
            return false;
        }

        $exponent = 10 ** $precision;
        $product = $exponent * $number;

        if ($mode === self::ROUND_UP) {
            return (ceil($product) + ceil($product - ceil($product))) / $exponent;
        }

        if ($mode === self::ROUND_DOWN) {
            return (floor($product) + floor($product - floor($product))) / $exponent;
        }

        return false;
    }

    /**
     * @param array<int> $numbers
     * @param int        $precision
     * @param int        $mode (MathHelper::ROUND_UP, MathHelper::ROUND_DOWN)
     *
     * @return bool|float|int
     */
    public static function average(array $numbers, int $precision = 2, int $mode = self::ROUND_UP)
    {
        foreach ($numbers as $number) {
            if (!static::isFloat($number)) {
                return false;
            }
        }

        $result = array_sum($numbers) / count($numbers);

        return static::round($result, $precision, $mode);
    }

    /**
     * @param numeric $percentage
     * @param numeric $total
     *
     * @param int     $precision
     * @param int     $mode (MathHelper::ROUND_UP, MathHelper::ROUND_DOWN)
     *
     * @return bool|float|int
     */
    public static function percentage($percentage, $total, int $precision = 2, int $mode = self::ROUND_UP)
    {
        if (!static::isFloat($percentage) || !static::isFloat($total)) {
            return false;
        }

        if ($percentage <= 0 && $total <= 0) {
            return false;
        }

        $result = $total * $percentage / 100;

        return static::round($result, $precision, $mode);
    }

    /**
     * @param numeric $number
     *
     * @return bool|string
     */
    public static function ordinal($number)
    {
        if (!static::isInteger($number) || $number <= 0) {
            return false;
        }

        $append = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

        if ($number % 100 >= 11 && $number % 100 <= 13) {
            return $number . 'th';
        }

        return $number . $append[$number % 10];
    }

    /**
     * @param numeric $number
     *
     * @return bool|int
     */
    public static function faculty($number)
    {
        if (!static::isInteger($number) || $number < 0) {
            return false;
        }

        if ((int)$number === 0) {
            return 1;
        }

        return (int)$number * static::faculty($number - 1);
    }

    /**
     * @param array<int> $numbers
     * @param int|null   $id
     *
     * @return array<int>
     */
    public static function combinations(array $numbers, int $id = null): array
    {
        $combinations = [];
        $count = count($numbers);
        $total = 2 ** $count;

        for ($i = 0; $i < $total; $i++) {
            for ($j = 0; $j < $count; $j++) {
                if ((2 ** $j) & $i) {
                    $combinations[$i][] = $numbers[$j];
                }
            }
        }

        return $id === null ? $combinations : $combinations[$id] ?? [];
    }

    /**
     * @param numeric $number
     * @param int     $min
     *
     * @return bool|int
     */
    public static function min($number, int $min)
    {
        if (!static::isFloat($number)) {
            return false;
        }

        if ($number < $min) {
            $number = $min;
        }

        return $number;
    }

    /**
     * @param numeric $number
     * @param int     $max
     *
     * @return bool|int
     */
    public static function max($number, int $max)
    {
        if (!static::isFloat($number)) {
            return false;
        }

        if ($number > $max) {
            $number = $max;
        }

        return $number;
    }

    /**
     * @param numeric $number
     *
     * @return bool
     */
    public static function isInteger($number): bool
    {
        return is_numeric($number) && (string)(int)$number === (string)$number;
    }

    /**
     * @param numeric $number
     *
     * @return bool
     */
    public static function isFloat($number): bool
    {
        $lnum = '[0-9]+';
        $dnum = "([0-9]*[\\.]{$lnum})|({$lnum}[\\.][0-9]*)";
        $exponent = "[+-]?(({$lnum}|{$dnum})([eE][+-]?{$lnum})?)";

        return is_numeric($number) && preg_match("/^{$exponent}$/", (string)$number) === 1;
    }

    /**
     * @param numeric $number
     * @param int     $min
     * @param int     $max
     *
     * @return bool
     */
    public static function isInRange($number, int $min, int $max): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return $number >= $min && $number <= $max;
    }

    /**
     * @param numeric $number
     * @param int     $min
     * @param int     $max
     *
     * @return bool
     */
    public static function isOutOfRange($number, int $min, int $max): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return $number < $min || $number > $max;
    }

    /**
     * @param numeric $number
     *
     * @return bool
     */
    public static function isEven($number): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return $number % 2 === 0;
    }

    /**
     * @param numeric $number
     *
     * @return bool
     */
    public static function isOdd($number): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return !static::isEven($number);
    }

    /**
     * @param numeric $number
     * @param bool    $zero
     *
     * @return bool
     */
    public static function isPositive($number, bool $zero = true): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return $zero ? $number >= 0 : $number > 0;
    }

    /**
     * @param numeric $number
     *
     * @return bool
     */
    public static function isNegative($number): bool
    {
        if (!static::isFloat($number)) {
            return false;
        }

        return $number < 0;
    }
}
