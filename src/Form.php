<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use DateTimeInterface;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Form
{
    /**
     * @var string[]
     */
    protected static array $reserved = [
        'method',
        'action',
        'files',
    ];

    /**
     * @var string[]
     */
    protected static array $spoofedMethods = [
        'DELETE',
        'PATCH',
        'PUT',
    ];

    /**
     * @var string[]
     */
    protected static array $labels = [];

    /**
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function open(array $options = []): string
    {
        $method = Arr::get($options, 'method', 'post');

        $attributes['accept-charset'] = 'UTF-8';
        $attributes['method'] = self::getMethod($method);

        if ($action = self::getAction($options)) {
            $attributes['action'] = $action;
        }

        $append = self::getAppendage($method);

        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
        }

        $attributes = [...$attributes, ...Arr::except($options, self::$reserved)];
        $attributes = HTML::attributes($attributes);

        return '<form' . $attributes . '>' . $append;
    }

    /**
     * @param string $method
     *
     * @return string
     */
    public static function getMethod(string $method): string
    {
        $method = strtoupper($method);

        return $method !== 'GET' ? 'POST' : $method;
    }

    /**
     * @param string[] $options
     *
     * @return string|null
     */
    public static function getAction(array $options): string|null
    {
        return $options['action'] ?? null;
    }

    /**
     * @param string $method
     *
     * @return string
     */
    protected static function getAppendage(string $method): string
    {
        [$method, $appendage] = [strtoupper($method), ''];

        if (in_array($method, self::$spoofedMethods, true)) {
            $appendage .= self::hidden('_method', $method);
        }

        return $appendage;
    }

    /**
     * @return string
     */
    public static function close(): string
    {
        self::$labels = [];

        return '</form>';
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     * @param bool                 $escapeHTML
     *
     * @return string
     */
    public static function label(
        string $name,
        string|null $value = null,
        array $options = [],
        bool $escapeHTML = true
    ): string {
        self::$labels[] = $name;

        $options = HTML::attributes($options);
        $value = self::formatLabel($name, $value);

        if ($escapeHTML) {
            $value = Str::escape($value, ENT_QUOTES, false);
        }

        return '<label for="' . $name . '"' . $options . '>' . $value . '</label>';
    }

    /**
     * @param string      $name
     * @param string|null $value
     *
     * @return string
     */
    protected static function formatLabel(string $name, string|null $value = null): string
    {
        return $value ?: ucwords(str_replace(['_', '-'], ' ', $name));
    }

    /**
     * @param string               $type
     * @param string|null          $name
     * @param mixed                $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function input(string $type, string|null $name, mixed $value = null, array $options = []): string
    {
        if (!isset($options['name'])) {
            $options['name'] = $name;
        }

        $id = self::getIdAttribute($name, $options);

        $merge = compact('type', 'value', 'id');
        $options = [...$options, ...$merge];

        return '<input' . HTML::attributes($options) . '>';
    }

    /**
     * @param string|null          $name
     * @param array<string, mixed> $options
     *
     * @return string|null
     */
    protected static function getIdAttribute(string|null $name, array $options): string|null
    {
        if (array_key_exists('id', $options)) {
            return $options['id'];
        }

        if (in_array($name, self::$labels, true)) {
            return $name;
        }

        return null;
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function text(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('text', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function password(string $name, array $options = []): string
    {
        return self::input('password', $name, '', $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function range(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('range', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function hidden(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('hidden', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function search(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('search', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function email(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('email', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function tel(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('tel', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function number(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('number', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function date(string $name, DateTimeInterface|string|null $value = null, array $options = []): string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('Y-m-d');
        }

        return self::input('date', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function datetime(
        string $name,
        DateTimeInterface|string|null $value = null,
        array $options = []
    ): string {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format(DateTimeInterface::RFC3339);
        }

        return self::input('datetime', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function datetimeLocal(
        string $name,
        DateTimeInterface|string|null $value = null,
        array $options = []
    ): string {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return self::input('datetime-local', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function time(string $name, DateTimeInterface|string|null $value = null, array $options = []): string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('H:i');
        }

        return self::input('time', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function week(string $name, DateTimeInterface|string|null $value = null, array $options = []): string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('Y-\WW');
        }

        return self::input('week', $name, $value, $options);
    }

    /**
     * @param string                        $name
     * @param DateTimeInterface|string|null $value
     * @param array<string, mixed>          $options
     *
     * @return string
     */
    public static function month(string $name, DateTimeInterface|string|null $value = null, array $options = []): string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('Y-m');
        }

        return self::input('month', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function url(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('url', $name, $value, $options);
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function file(string $name, array $options = []): string
    {
        return self::input('file', $name, null, $options);
    }

    /**
     * @param string               $name
     * @param string               $url
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function image(string $name, string $url, array $options = []): string
    {
        $options['src'] = $url;

        return self::input('image', $name, null, $options);
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function color(string $name, string|null $value = null, array $options = []): string
    {
        return self::input('color', $name, $value, $options);
    }

    /**
     * @param string               $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function reset(string $value, array $options = []): string
    {
        return self::input('reset', null, $value, $options);
    }

    /**
     * @param string|null          $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function submit(string|null $value = null, array $options = []): string
    {
        return self::input('submit', null, $value, $options);
    }

    /**
     * @param string               $value
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function button(string $value, array $options = []): string
    {
        if (!array_key_exists('type', $options)) {
            $options['type'] = 'button';
        }

        return '<button' . HTML::attributes($options) . '>' . $value . '</button>';
    }

    /**
     * @param string               $name
     * @param mixed                $value
     * @param bool                 $checked
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function checkbox(string $name, mixed $value = 1, bool $checked = false, array $options = []): string
    {
        return self::checkable('checkbox', $name, $value, $checked, $options);
    }

    /**
     * @param string               $name
     * @param mixed                $value
     * @param bool                 $checked
     * @param array<string, mixed> $options
     *
     * @return string
     */
    public static function radio(string $name, mixed $value = null, bool $checked = false, array $options = []): string
    {
        if ($value === null) {
            $value = $name;
        }

        return self::checkable('radio', $name, $value, $checked, $options);
    }

    /**
     * @param string               $type
     * @param string               $name
     * @param mixed                $value
     * @param bool                 $checked
     * @param array<string, mixed> $options
     *
     * @return string
     */
    protected static function checkable(string $type, string $name, mixed $value, bool $checked, array $options): string
    {
        if (self::getCheckedState($type, $name, $value, $checked)) {
            $options['checked'] = 'checked';
        }

        return self::input($type, $name, $value, $options);
    }

    /**
     * @param string $type
     * @param string $name
     * @param mixed  $value
     * @param bool   $checked
     *
     * @return bool
     */
    protected static function getCheckedState(string $type, string $name, mixed $value, bool $checked): bool
    {
        return match ($type) {
            'checkbox' => (bool)self::getValueAttribute($name, $checked),
            'radio' => $checked ?: self::getValueAttribute($name) === $value,
            default => false,
        };
    }

    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @return mixed
     */
    protected static function getValueAttribute(mixed $name, mixed $value = null): mixed
    {
        if ($name === null) {
            return $value;
        }

        return $value ?? null;
    }

    /**
     * @param string               $name
     * @param string|null          $value
     * @param array<string, mixed> $options
     * @param bool                 $escapeHTML
     *
     * @return string
     */
    public static function textarea(
        string $name,
        string|null $value = null,
        array $options = [],
        bool $escapeHTML = true
    ): string {
        if (!isset($options['name'])) {
            $options['name'] = $name;
        }

        $options = self::setTextareaSizes($options);
        $options['id'] = self::getIdAttribute($name, $options);

        unset($options['size']);

        $options = HTML::attributes($options);

        if ($escapeHTML) {
            $value = Str::escape((string)$value, ENT_QUOTES, false);
        }

        return '<textarea' . $options . '>' . $value . '</textarea>';
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected static function setTextareaSizes(array $options): array
    {
        if (isset($options['size'])) {
            return self::setQuickTextareaSize($options);
        }

        $cols = Arr::get($options, 'cols', 50);
        $rows = Arr::get($options, 'rows', 10);

        $merge = compact('cols', 'rows');
        return [...$options, ...$merge];
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected static function setQuickTextareaSize(array $options): array
    {
        $segments = explode('x', $options['size']);

        return [...$options, ...['cols' => $segments[0], 'rows' => $segments[1]]];
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $list
     * @param mixed                $selected
     * @param array<string, mixed> $selectAttributes
     * @param array<string, mixed> $optionsAttributes
     * @param array<string, mixed> $optgroupsAttributes
     *
     * @return string
     */
    public static function select(
        string $name,
        array $list = [],
        mixed $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ): string {
        $selected = self::getValueAttribute($name, $selected);
        $selectAttributes['id'] = self::getIdAttribute($name, $selectAttributes);

        if (!isset($selectAttributes['name'])) {
            $selectAttributes['name'] = $name;
        }

        $html = [];

        if (isset($selectAttributes['placeholder'])) {
            $html[] = self::placeholderOption($selectAttributes['placeholder'], $selected);
            unset($selectAttributes['placeholder']);
        }

        foreach ($list as $value => $display) {
            $optionAttributes = $optionsAttributes[$value] ?? [];
            $optgroupAttributes = $optgroupsAttributes[$value] ?? [];
            $html[] = self::getSelectOption($display, $value, $selected, $optionAttributes, $optgroupAttributes);
        }

        $selectAttributes = HTML::attributes($selectAttributes);
        $list = implode('', $html);

        return '<select' . $selectAttributes . '>' . $list . '</select>';
    }

    /**
     * @param array<string, mixed>|string|int $display
     * @param mixed                           $value
     * @param mixed                           $selected
     * @param array<string, mixed>            $attributes
     * @param array<string, mixed>            $optgroupAttributes
     *
     * @return string
     */
    protected static function getSelectOption(
        array|string|int $display,
        mixed $value,
        mixed $selected,
        array $attributes = [],
        array $optgroupAttributes = []
    ): string {
        if (is_iterable($display)) {
            return self::optionGroup($display, $value, $selected, $optgroupAttributes, $attributes);
        }

        return self::option((string)$display, $value, $selected, $attributes);
    }

    /**
     * @param string               $display
     * @param mixed                $value
     * @param mixed                $selected
     * @param array<string, mixed> $options
     *
     * @return string
     */
    protected static function option(string $display, mixed $value, mixed $selected, array $options = []): string
    {
        $selected = self::getSelectedValue($value, $selected);
        $options = [...['value' => $value, 'selected' => $selected], ...$options];
        $string = '<option' . HTML::attributes($options) . '>';
        $string .= Str::escape($display, ENT_QUOTES, false) . '</option>';

        return $string;
    }

    /**
     * @param array<string, mixed> $list
     * @param string               $label
     * @param mixed                $selected
     * @param array<string, mixed> $attributes
     * @param array<string, mixed> $optgroupAttributes
     * @param int                  $level
     *
     * @return string
     */
    protected static function optionGroup(
        array $list,
        string $label,
        mixed $selected,
        array $attributes = [],
        array $optgroupAttributes = [],
        int $level = 0
    ): string {
        $html = [];
        $space = str_repeat("&nbsp;", $level);

        foreach ($list as $value => $display) {
            $optionAttributes = $optgroupAttributes[$value] ?? [];

            if (is_iterable($display)) {
                $html[] = self::optionGroup(
                    (array)$display,
                    $value,
                    $selected,
                    $attributes,
                    $optionAttributes,
                    $level + 5
                );
            } else {
                $html[] = self::option($space . $display, $value, $selected, $optionAttributes);
            }
        }

        return '<optgroup label="' .
            Str::escape($space . $label, ENT_QUOTES, false) . '"' .
            HTML::attributes($attributes) . '>' .
            implode('', $html) . '</optgroup>';
    }

    /**
     * @param string $display
     * @param mixed  $selected
     *
     * @return string
     */
    protected static function placeholderOption(string $display, mixed $selected): string
    {
        $selected = self::getSelectedValue(null, $selected);

        $options = [
            'selected' => $selected,
            'value' => '',
        ];

        return '<option' . HTML::attributes($options) . '>' . Str::escape($display, ENT_QUOTES, false) . '</option>';
    }

    /**
     * @param mixed $value
     * @param mixed $selected
     *
     * @return bool|string|null
     */
    protected static function getSelectedValue(mixed $value, mixed $selected): bool|string|null
    {
        if (is_array($selected)) {
            return in_array($value, $selected, true) ? 'selected' : null;
        }

        if (is_int($value) && is_bool($selected)) {
            return (bool)$value === $selected;
        }

        return ((string)$value === (string)$selected) ? 'selected' : null;
    }

    /**
     * @param string               $name
     * @param int|string           $begin
     * @param int|string           $end
     * @param mixed                $selected
     * @param array<string, mixed> $selectAttributes
     * @param array<string, mixed> $optionsAttributes
     *
     * @return string
     */
    public static function selectRange(
        string $name,
        int|string $begin,
        int|string $end,
        mixed $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = []
    ): string {
        $range = array_combine($range = range($begin, $end), $range);

        return self::select($name, $range, $selected, $selectAttributes, $optionsAttributes);
    }

    /**
     * @param string               $id
     * @param array<string, mixed> $list
     *
     * @return string
     */
    public static function datalist(string $id, array $list = []): string
    {
        $attributes['id'] = $id;
        $html = [];

        if (self::isAssocArray($list)) {
            foreach ($list as $value => $display) {
                $html[] = self::option($display, $value, null, []);
            }
        } else {
            foreach ($list as $value) {
                $html[] = self::option($value, $value, null, []);
            }
        }

        $attributes = HTML::attributes($attributes);
        $list = implode('', $html);

        return '<datalist' . $attributes . '>' . $list . '</datalist>';
    }

    /**
     * @param array<string, mixed> $array
     *
     * @return bool
     */
    protected static function isAssocArray(array $array): bool
    {
        return array_values($array) !== $array;
    }
}
