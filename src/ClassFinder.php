<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class ClassFinder
{
    /**
     * @param string $directory
     *
     * @return string[]
     */
    public static function getClassesFromDirectory(string $directory): array
    {
        $classes = [];

        foreach (glob($directory . '/*.php') as $filename) {
            $className = self::getClassBasename($filename);
            $namespace = self::getNamespaceFromFile($filename);

            $classes[] = $namespace . '\\' . $className;
        }

        return $classes;
    }

    /**
     * @param string|object $class
     *
     * @return string
     */
    public static function getClassBasename(string|object $class): string
    {
        $class = is_object($class) ? $class::class : $class;

        return basename(str_replace('\\', '/', $class), '.php');
    }

    /**
     * @param string|object $filename
     *
     * @return string
     * @deprecated Will be removed in v3.0. Use "getClassBasename" instead.
     */
    public static function getClassNameFromFile(string|object $filename): string
    {
        return self::getClassBasename($filename);
    }

    /**
     * @param string $filename
     *
     * @return string|null
     */
    public static function getNamespaceFromFile(string $filename): ?string
    {
        $contents = is_file($filename) ? file_get_contents($filename) : null;

        if (!is_string($contents)) {
            return null;
        }

        $tokens = token_get_all($contents);
        $hasNamespace = false;
        $namespace = null;

        foreach ($tokens as $token) {
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                $hasNamespace = true;
            }

            if ($hasNamespace) {
                if (is_array($token) && $token[0] === T_NAME_QUALIFIED) {
                    $namespace .= $token[1];
                } elseif ($token === ';') {
                    $hasNamespace = false;
                }
            }
        }

        return $namespace;
    }
}
