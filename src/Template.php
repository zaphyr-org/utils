<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use Zaphyr\Utils\Exceptions\UtilsException;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class Template
{
    /**
     * @param string                $template
     * @param array<string, string> $data
     *
     * @throws UtilsException
     * @return string
     */
    public static function render(string $template, array $data = []): string
    {
        $code = is_file($template) ? file_get_contents($template) : false;

        if ($code === false) {
            throw new UtilsException('Template file "' . $template . '" not found');
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                if (is_string($value) !== true) {
                    throw new UtilsException(
                        'Template data "' . $name . '" must be a string, ' . gettype($value) . ' given'
                    );
                }

                $code = (string)str_replace('%' . $name . '%', Str::escape($value), $code);
            }
        }

        return $code;
    }
}
