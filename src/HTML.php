<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class HTML
{
    /**
     * @param array<string, mixed> $attributes
     *
     * @return string
     */
    public static function attributes(array $attributes): string
    {
        $html = [];

        foreach ($attributes as $key => $value) {
            $element = static::attributeElement($key, $value);

            if ($element !== null) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return string|null
     */
    public static function attributeElement(mixed $key, mixed $value): ?string
    {
        if (is_numeric($key)) {
            return $value;
        }

        if (is_bool($value) && $key !== 'value') {
            return $value ? $key : '';
        }

        if (is_array($value) && $key === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }

        if ($value !== null) {
            return $key . '="' . Str::escape((string)$value) . '"';
        }

        return null;
    }
}
