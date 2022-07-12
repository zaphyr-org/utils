<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\ClassFinder;

class ClassFinderTest extends TestCase
{
    /* -------------------------------------------------
     * GET CLASSES FROM DIRECTORY
     * -------------------------------------------------
     */

    public function testGetClassesFromDirectory(): void
    {
        $classes = ClassFinder::getClassesFromDirectory(__DIR__);

        self::assertGreaterThan(0, count($classes));
    }

    /* -------------------------------------------------
     * GET CLASS NAME FROM FILE
     * -------------------------------------------------
     */

    public function testGetClassNameFromFile(): void
    {
        $className = ClassFinder::getClassNameFromFile(__FILE__);

        self::assertEquals('ClassFinderTest', $className);
    }

    /* -------------------------------------------------
     * GET NAMESPACE FROM FILE
     * -------------------------------------------------
     */

    public function testGetNamespaceFromFile(): void
    {
        $namespace = ClassFinder::getNamespaceFromFile(__FILE__);

        self::assertEquals('Zaphyr\UtilsTests', $namespace);
    }

    public function testGetNamespaceFromFileReturnsNullWhenNoNamespaceIsPresent(): void
    {
        $namespace = ClassFinder::getNamespaceFromFile(\dirname(__DIR__) . '/phpunit.xml.dist');

        self::assertNull($namespace);
    }
}
