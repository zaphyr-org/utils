<?php

declare(strict_types=1);

namespace Zaphyr\Utils;

use ErrorException;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Zaphyr\Utils\Exceptions\FileNotFoundException;

/**
 * @author merloxx <merloxx@zaphyr.org>
 */
class File
{
    /**
     * @param string $path
     *
     * @return bool
     * @deprecated Will be removed in v3.0. Use PHP built-in function "file_exists"
     */
    public static function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @param string $file
     *
     * @return bool
     * @deprecated Will be removed in v3.0. Use PHP built-in function "is_file"
     */
    public static function isFile(string $file): bool
    {
        return is_file($file);
    }

    /**
     * @param string $directory
     *
     * @return bool
     * @deprecated Will be removed in v3.0. Use PHP built-in function "is_dir"
     */
    public static function isDirectory(string $directory): bool
    {
        return is_dir($directory);
    }

    /**
     * @param string $path
     * @param int    $options
     *
     * @return array<string, string>|string|null
     */
    public static function info(string $path, int $options = PATHINFO_ALL): array|string|null
    {
        if (!file_exists($path)) {
            return null;
        }

        return pathinfo($path, $options);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public static function name(string $path): string|null
    {
        $info = static::info($path, PATHINFO_FILENAME);

        return is_string($info) ? $info : null;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public static function basename(string $path): string|null
    {
        $info = static::info($path, PATHINFO_BASENAME);

        return is_string($info) ? $info : null;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public static function dirname(string $path): string|null
    {
        $info = static::info($path, PATHINFO_DIRNAME);

        return is_string($info) ? $info : null;
    }

    /**
     * @param string $file
     *
     * @return string|null
     */
    public static function extension(string $file): string|null
    {
        if (!is_file($file)) {
            return null;
        }

        $info = static::info($file, PATHINFO_EXTENSION);

        return is_string($info) ? $info : null;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public static function type(string $path): string|null
    {
        if (!file_exists($path)) {
            return null;
        }

        $result = filetype($path);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public static function mimeType(string $path): string|null
    {
        if (!file_exists($path)) {
            return null;
        }

        $info = finfo_open(FILEINFO_MIME_TYPE);

        if ($info === false) {
            return null;
        }

        $result = finfo_file($info, $path);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string $path
     *
     * @return int|null
     */
    public static function size(string $path): int|null
    {
        return file_exists($path) ? filesize($path) : null;
    }

    /**
     * @param string $file
     *
     * @return string|null
     */
    public static function hash(string $file): string|null
    {
        if (!is_file($file)) {
            return null;
        }

        $result = md5_file($file);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string   $file
     * @param int|null $mode
     *
     * @return bool|string
     */
    public static function chmod(string $file, int|null $mode = null): bool|string
    {
        if ($mode) {
            return chmod($file, $mode);
        }

        return substr(sprintf('%o', fileperms($file)), -4);
    }

    /**
     * @param string $path
     *
     * @return int|null
     */
    public static function lastModified(string $path): int|null
    {
        return file_exists($path) ? filemtime($path) : null;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isReadable(string $path): bool
    {
        return file_exists($path) && is_readable($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isWritable(string $path): bool
    {
        return file_exists($path) && is_writable($path);
    }

    /**
     * @param string $pattern
     * @param int    $flags
     *
     * @return string[]|null
     */
    public static function glob(string $pattern, int $flags = 0): array|null
    {
        $results = glob($pattern, $flags);

        if (!$results) {
            return null;
        }

        return $results;
    }

    /**
     * @param string $directory
     * @param bool   $hidden
     *
     * @return SplFileInfo[]|null
     */
    public static function files(string $directory, bool $hidden = false): array|null
    {
        if (!is_dir($directory)) {
            return null;
        }

        $files = [];

        /** @var SplFileInfo $item */
        foreach (new FilesystemIterator($directory) as $item) {
            if ($item->isFile()) {
                if (!$hidden && static::isHidden($item->getFilename())) {
                    continue;
                }

                $files[] = $item;
            }
        }

        natsort($files);

        return $files;
    }

    /**
     * @param string $directory
     * @param bool   $hidden
     *
     * @return SplFileInfo[]|null
     */
    public static function allFiles(string $directory, bool $hidden = false): array|null
    {
        if (!is_dir($directory)) {
            return null;
        }

        $files = [];
        $flags = FilesystemIterator::SKIP_DOTS;
        $directories = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, $flags));

        foreach ($directories as $item) {
            if (!$hidden && (static::isHidden($item->getFilename()) || static::isHidden($item->getPath()))) {
                continue;
            }

            $files[] = $item;
        }

        natsort($files);

        return $files;
    }

    /**
     * @param string $directory
     * @param bool   $hidden
     *
     * @return SplFileInfo[]|null
     */
    public static function directories(string $directory, bool $hidden = false): array|null
    {
        if (!is_dir($directory)) {
            return null;
        }

        $directories = [];
        $flags = FilesystemIterator::SKIP_DOTS;

        /** @var SplFileInfo $item */
        foreach (new RecursiveDirectoryIterator($directory, $flags) as $item) {
            if ($item->isDir()) {
                if (!$hidden && static::isHidden($item->getPathname())) {
                    continue;
                }

                $directories[] = $item;
            }
        }

        natsort($directories);

        return $directories;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected static function isHidden(string $path): bool
    {
        $partials = explode(DIRECTORY_SEPARATOR, $path);
        $path = end($partials);

        return $path[0] === '.';
    }

    /**
     * @param string $file
     *
     * @throws FileNotFoundException
     * @return mixed
     */
    public static function getRequire(string $file): mixed
    {
        if (!is_file($file)) {
            throw new FileNotFoundException('The file . "' . $file . '" does not exist');
        }

        return require $file;
    }

    /**
     * @param string $file
     *
     * @throws FileNotFoundException
     */
    public static function getRequireOnce(string $file): void
    {
        if (!is_file($file)) {
            throw new FileNotFoundException('The file "' . $file . '" does not exist');
        }

        require_once $file;
    }

    /**
     * @param string $file
     *
     * @throws FileNotFoundException
     * @return string|null
     *
     */
    public static function read(string $file): string|null
    {
        if (!is_file($file)) {
            throw new FileNotFoundException('The file "' . $file . '" does not exist');
        }

        $result = file_get_contents($file);

        return is_string($result) ? $result : null;
    }

    /**
     * @param string $file
     * @param string $contents
     * @param bool   $lock
     *
     * @return int
     */
    public static function put(string $file, string $contents, bool $lock = false): int
    {
        return file_put_contents($file, $contents, $lock ? LOCK_EX : 0);
    }

    /**
     * @param string $path
     * @param string $contents
     *
     * @throws FileNotFoundException
     */
    public static function replace(string $path, string $contents): void
    {
        clearstatcache(true, $path);

        $path = realpath($path) ?: $path;
        $tempPath = tempnam(dirname($path), basename($path));

        if (!$tempPath) {
            throw new FileNotFoundException('The path . "' . $path . '" does not exist');
        }

        chmod($tempPath, 0777 - umask());
        file_put_contents($tempPath, $contents);
        rename($tempPath, $path);
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @throws FileNotFoundException
     * @return int
     *
     */
    public static function prepend(string $file, string $contents): int
    {
        if (file_exists($file)) {
            return static::put($file, $contents . static::read($file));
        }

        return static::put($file, $contents);
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @return int
     */
    public static function append(string $file, string $contents): int
    {
        return file_put_contents($file, $contents, FILE_APPEND);
    }

    /**
     * @param string|string[] $paths
     *
     * @return bool
     */
    public static function delete(string|array $paths): bool
    {
        $paths = is_array($paths) ? $paths : func_get_args();
        $success = true;

        foreach ($paths as $path) {
            try {
                if (!@unlink($path)) {
                    $success = false;
                }
            } catch (ErrorException) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * @param string $file
     * @param string $target
     *
     * @return bool
     */
    public static function move(string $file, string $target): bool
    {
        return is_file($file) && rename($file, $target);
    }

    /**
     * @param string $file
     * @param string $target
     *
     * @return bool
     */
    public static function copy(string $file, string $target): bool
    {
        return is_file($file) && copy($file, $target);
    }

    /**
     * @param string $file
     * @param mixed  $contents
     * @param bool   $lock
     *
     * @return int
     */
    public static function serialize(string $file, mixed $contents, bool $lock = false): int
    {
        return static::put($file, serialize($contents), $lock);
    }

    /**
     * @param string $file
     *
     * @throws FileNotFoundException
     * @return mixed
     */
    public static function unserialize(string $file): mixed
    {
        $contents = static::read($file);

        return $contents !== null ? unserialize($contents) : null;
    }

    /**
     * @param string $path
     * @param int    $mode
     * @param bool   $recursive
     * @param bool   $force
     *
     * @return bool
     */
    public static function createDirectory(
        string $path,
        int $mode = 0755,
        bool $recursive = false,
        bool $force = false
    ): bool {
        return $force ? @mkdir($path, $mode, $recursive) : mkdir($path, $mode, $recursive);
    }

    /**
     * @param string $directory
     * @param bool   $preserve
     *
     * @return bool
     */
    public static function deleteDirectory(string $directory, bool $preserve = false): bool
    {
        if (!is_dir($directory)) {
            return false;
        }

        $items = new FilesystemIterator($directory);

        /** @var SplFileInfo $item */
        foreach ($items as $item) {
            if ($item->isDir() && !$item->isLink()) {
                static::deleteDirectory($item->getPathname());
            } else {
                static::delete($item->getPathname());
            }
        }

        if (!$preserve) {
            @rmdir($directory);
        }

        return true;
    }

    /**
     * @param string $directory
     *
     * @return bool
     */
    public static function cleanDirectory(string $directory): bool
    {
        return static::deleteDirectory($directory, true);
    }

    /**
     * @param string $from
     * @param string $to
     * @param bool   $overwrite
     *
     * @return bool
     */
    public static function moveDirectory(string $from, string $to, bool $overwrite = false): bool
    {
        if ($overwrite && is_dir($to) && !static::deleteDirectory($to)) {
            return false;
        }

        return @rename($from, $to) === true;
    }

    /**
     * @param string   $directory
     * @param string   $destination
     * @param int|null $options
     *
     * @return bool
     */
    public static function copyDirectory(string $directory, string $destination, int|null $options = null): bool
    {
        if (!is_dir($directory)) {
            return false;
        }

        $options = $options ?: FilesystemIterator::SKIP_DOTS;

        if (!is_dir($destination)) {
            static::createDirectory($destination, 0777, true);
        }

        $items = new FilesystemIterator($directory, $options);

        /** @var SplFileInfo $item */
        foreach ($items as $item) {
            $target = $destination . DIRECTORY_SEPARATOR . $item->getBasename();

            if ($item->isDir()) {
                $path = $item->getPathname();

                if (!static::copyDirectory($path, $target, $options)) {
                    return false;
                }
            } elseif (!static::copy($item->getPathname(), $target)) {
                return false;
            }
        }

        return true;
    }
}
