<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use PHPUnit\Framework\TestCase;
use stdClass;
use Zaphyr\Utils\ClassFinder;
use Zaphyr\Utils\Exceptions\FileNotFoundException;
use Zaphyr\Utils\Exceptions\UtilsException;

class ClassFinderTest extends TestCase
{
    /* -------------------------------------------------
     * GET CLASSES FROM DIRECTORY
     * -------------------------------------------------
     */

    public function testGetClassesFromDirectory(): void
    {
        self::assertSame(
            [
                FileNotFoundException::class,
                UtilsException::class
            ],
            ClassFinder::getClassesFromDirectory(
                '/Users/merloxx/PhpstormProjects/zaphyr/repositories/utils/src/Exceptions'
            )
        );
    }

    public function testGetClassesFromDirectoryReturnsEmptyArrayWhenNoResult(): void
    {
        self::assertEmpty(ClassFinder::getClassesFromDirectory('empty/path'));
    }

    /* -------------------------------------------------
     * GET CLASS BASENAME
     * -------------------------------------------------
     */

    public function testGetClassBasename(): void
    {
        self::assertSame('ClassFinderTest', ClassFinder::getClassBasename(__FILE__));
        self::assertSame('ClassFinderTest', ClassFinder::getClassBasename(__CLASS__));
        self::assertSame('ClassFinderTest', ClassFinder::getClassBasename('ClassFinderTest'));
        self::assertSame('ClassFinderTest', ClassFinder::getClassBasename('\ClassFinderTest'));
        self::assertSame('Foo', ClassFinder::getClassBasename('\\\\Foo'));
        self::assertSame('Baz', ClassFinder::getClassBasename('\Foo\Bar\Baz'));
        self::assertSame('Baz', ClassFinder::getClassBasename('\Foo/Bar\Baz/'));
        self::assertSame('ClassFinderTest', ClassFinder::getClassBasename($this));
        self::assertSame('stdClass', ClassFinder::getClassBasename(new stdClass()));
        self::assertSame('0', ClassFinder::getClassBasename('0'));
        self::assertSame('', ClassFinder::getClassBasename(''));
        self::assertSame('', ClassFinder::getClassBasename('\\'));
        self::assertSame('', ClassFinder::getClassBasename('//'));
    }

    /* -------------------------------------------------
     * GET NAMESPACE FROM FILE
     * -------------------------------------------------
     */

    public function testGetNamespaceFromFile(): void
    {
        self::assertSame('Zaphyr\UtilsTests\Unit', ClassFinder::getNamespaceFromFile(__FILE__));
    }

    public function testGetNamespaceFromFileReturnsNullWhenNoNamespaceIsPresent(): void
    {
        self::assertNull(ClassFinder::getNamespaceFromFile(dirname(__DIR__) . '/phpunit.xml.dist'));
    }

    public function testGetNamespaceFromFileReturnsNullWhenFileNotFound(): void
    {
        self::assertNull(ClassFinder::getNamespaceFromFile('/file/not/exists'));
    }
}
