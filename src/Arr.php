<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use ArrayAccess;

/**
 * Class Arr
 *
 * @package Zaphyr\Utils
 * @author  merloxx <merloxx@zaphyr.org>
 */
class Arr
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * @param ArrayAccess|array<mixed> $array
     * @param int|string               $key
     *
     * @return bool
     */
    public static function exists($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * @param array<string, mixed> $array
     * @param string[]|string      $key
     * @param mixed                $value
     *
     * @return array<string, mixed>
     */
    public static function set(array &$array, $key, $value = null): array
    {
        if ($value === null && is_array($key)) {
            return $array = $key;
        }

        $keys = is_string($key) ? explode('.', $key) : $key;

        while (count($keys) > 1) {
            $array = &$array[array_shift($keys)];
        }

        if ($value === null) {
            $array[] = $key;
        } else {
            $array[array_shift($keys)] = $value;
        }

        return $array;
    }

    /**
     * @param array<string, mixed> $array
     * @param string[]|string      $key
     * @param mixed                $value
     *
     * @return array<string, mixed>
     */
    public static function add(array &$array, $key, $value = null): array
    {
        if (!static::has($array, $key)) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * @param ArrayAccess|array<string, mixed> $array
     * @param string|null                      $key
     * @param mixed                            $default
     *
     * @return mixed
     */
    public static function get($array, ?string $key, $default = null)
    {
        if (!static::accessible($array)) {
            return $default;
        }

        if ($key === null) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * @param array<mixed>  $array
     * @param callable|null $callback
     * @param mixed         $default
     *
     * @return mixed
     */
    public static function first(array $array, callable $callback = null, $default = null)
    {
        if ($callback === null) {
            if (empty($array)) {
                return $default;
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * @param array<mixed>  $array
     * @param callable|null $callback
     * @param mixed         $default
     *
     * @return mixed
     */
    public static function last(array $array, callable $callback = null, $default = null)
    {
        if ($callback === null) {
            if (empty($array)) {
                return $default;
            }

            return end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * @param ArrayAccess|array<string, mixed> $array
     * @param string[]|string|null             $key
     *
     * @return bool
     */
    public static function has($array, $key): bool
    {
        if ($key === null) {
            return false;
        }

        $keys = (array)$key;

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if (static::exists($array, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param array<mixed> $array
     * @param callable     $callback
     *
     * @return array<mixed>
     */
    public static function where(array $array, callable $callback): array
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param array<string, mixed> $array
     * @param string[]|string      $key
     *
     * @return array<string, mixed>
     */
    public static function only(array $array, $key): array
    {
        return array_intersect_key($array, array_flip((array)$key));
    }

    /**
     * @param array<string, mixed>        $array
     * @param array<string, mixed>|string $keys
     */
    public static function forget(array &$array, $keys): void
    {
        $original = &$array;
        $keys = (array)$keys;

        foreach ($keys as $key) {
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (static::accessible($array) && static::exists($array, $part)) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * @param array<string, mixed> $array
     * @param string[]|string      $keys
     *
     * @return array<string, mixed>
     */
    public static function except(array $array, $keys): array
    {
        static::forget($array, $keys);

        return $array;
    }
}
