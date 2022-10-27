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
            $className = self::getClassNameFromFile($filename);
            $namespace = self::getNamespaceFromFile($filename);

            $classes[] = $namespace . '\\' . $className;
        }

        return $classes;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public static function getClassNameFromFile(string $filename): string
    {
        return basename($filename, '.php');
    }

    /**
     * @param string $filename
     *
     * @return string|null
     */
    public static function getNamespaceFromFile(string $filename): ?string
    {
        $contents = file_get_contents($filename);

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
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR], true)) {
                    $namespace .= $token[1];
                } elseif ($token === ';') {
                    $hasNamespace = false;
                }
            }
        }

        return $namespace;
    }
}
