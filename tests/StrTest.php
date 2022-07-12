<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Str;

class StrTest extends TestCase
{
    /* -------------------------------------------------
     * TO ASCII
     * -------------------------------------------------
     */

    public function testToAscii(): void
    {
        self::assertEquals('Taxisth alwphx', Str::toAscii('Τάχιστη αλώπηξ'));
    }

    /* -------------------------------------------------
     * TO ARRAY
     * -------------------------------------------------
     */

    public function testToArray(): void
    {
        self::assertEquals(['H', 'e', 'l', 'l', 'o'], Str::toArray('Hello'));
        self::assertEquals(['Τ', 'ά', 'χ', 'ι', 'σ', 'τ', 'η'], Str::toArray('Τάχιστη'));
    }

    /* -------------------------------------------------
     * TO BOOL
     * -------------------------------------------------
     */

    public function testToBool(): void
    {
        self::assertTrue(Str::toBool('true'));
        self::assertTrue(Str::toBool('1'));
        self::assertTrue(Str::toBool('on'));
        self::assertTrue(Str::toBool('On'));
        self::assertTrue(Str::toBool('ON'));

        self::assertFalse(Str::toBool('false'));
        self::assertFalse(Str::toBool('0'));
        self::assertFalse(Str::toBool('off'));
        self::assertFalse(Str::toBool('Off'));
        self::assertFalse(Str::toBool('OFF'));
        self::assertFalse(Str::toBool('no'));
        self::assertFalse(Str::toBool(''));
        self::assertFalse(Str::toBool(' '));
        self::assertFalse(Str::toBool('     '));
    }

    /* -------------------------------------------------
     * BEGINS WITH
     * -------------------------------------------------
     */

    public function testBeginsWith(): void
    {
        // string needles
        self::assertTrue(Str::beginsWith('Case sensitive', 'C'));
        self::assertTrue(Str::beginsWith('Case insensitive', 'C', false));
        self::assertTrue(Str::beginsWith('Τάχιστη αλώπηξ', 'Τάχιστη'));

        self::assertFalse(Str::beginsWith('Case sensitive', 'c'));
        self::assertFalse(Str::beginsWith('Τάχιστη αλώπηξ', 'αλώπηξ'));
        self::assertFalse(Str::beginsWith('Τάχιστη αλώπηξ', ''));

        // array needles
        self::assertTrue(Str::beginsWith('Case sensitive', ['e', 'C']));
        self::assertTrue(Str::beginsWith('Case sensitive', ['e', 'c'], false));
        self::assertTrue(Str::beginsWith('Τάχιστη αλώπηξ', ['αλώπηξ', 'Τάχιστη']));

        self::assertFalse(Str::beginsWith('Case sensitive', ['e', 'c']));
        self::assertFalse(Str::beginsWith('Τάχιστη αλώπηξ', ['']));
    }

    /* -------------------------------------------------
     * ENDS WITH
     * -------------------------------------------------
     */

    public function testEndsWith(): void
    {
        // string needles
        self::assertTrue(Str::endsWith('Case sensitive', 'e'));
        self::assertTrue(Str::endsWith('Case insensitive', 'e', false));
        self::assertTrue(Str::endsWith('Τάχιστη αλώπηξ', 'αλώπηξ'));

        self::assertFalse(Str::endsWith('Case sensitive', 'E'));
        self::assertFalse(Str::endsWith('Τάχιστη αλώπηξ', 'Τάχιστη'));

        // array needles
        self::assertTrue(Str::endsWith('Case sensitive', ['C', 'e']));
        self::assertTrue(Str::endsWith('Case sensitive', ['C', 'E'], false));
        self::assertTrue(Str::endsWith('Τάχιστη αλώπηξ', ['Τάχιστη', 'αλώπηξ']));

        self::assertFalse(Str::endsWith('Case sensitive', ['C', 'E']));
        self::assertFalse(Str::endsWith('Τάχιστη αλώπηξ', ['']));
    }

    /* -------------------------------------------------
     * CONTAINS
     * -------------------------------------------------
     */

    public function testContains(): void
    {
        // string needles
        self::assertTrue(Str::contains('Case sensitive', 'C'));
        self::assertTrue(Str::contains('Case insensitive', 'c', false));
        self::assertTrue(Str::contains('Τάχιστη αλώπηξ', 'Τάχιστη'));

        self::assertFalse(Str::contains('Case sensitive', 'c'));
        self::assertFalse(Str::contains('Τάχιστη αλώπηξ', ''));

        // array needles
        self::assertTrue(Str::contains('Case sensitive', ['f', 'C']));
        self::assertTrue(Str::contains('Case insensitive', ['c', 'S'], false));
        self::assertTrue(Str::contains('Τάχιστη αλώπηξ', ['αλώπηξ']));

        self::assertFalse(Str::contains('Case sensitive', ['c', 'S']));
        self::assertFalse(Str::contains('Τάχιστη αλώπηξ', ['']));
    }

    public function testContainsAll(): void
    {
        self::assertTrue(Str::containsAll('Case sensitive', ['C', 's']));
        self::assertTrue(Str::containsAll('Case insensitive', ['c', 'S'], false));
        self::assertTrue(Str::containsAll('Τάχιστη αλώπηξ', ['Τάχιστη', 'αλώπηξ']));

        self::assertFalse(Str::containsAll('Case sensitive', ['c', 'S']));
        self::assertFalse(Str::containsAll('Τάχιστη αλώπηξ', ['']));
    }

    /* -------------------------------------------------
     * LOWER
     * -------------------------------------------------
     */

    public function testLower(): void
    {
        self::assertEquals('foo', Str::lower('FOO'));
        self::assertEquals('foo', Str::lower('Foo'));
        self::assertEquals('τάχιστη αλώπηξ', Str::lower('Τάχιστη αλώπηξ'));
    }

    public function testLowerFirst(): void
    {
        self::assertEquals('fOO', Str::lowerFirst('FOO'));
        self::assertEquals('foO', Str::lowerFirst('FoO'));
        self::assertEquals('τΆΧΙΣΤΗ ΑΛΏΠΗΞ', Str::lowerFirst('ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ'));
    }

    /* -------------------------------------------------
     * UPPER
     * -------------------------------------------------
     */

    public function testUpper(): void
    {
        self::assertEquals('FOO', Str::upper('foo'));
        self::assertEquals('FOO', Str::upper('fOo'));
        self::assertEquals('ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ', Str::upper('Τάχιστη αλώπηξ'));
    }

    public function testUpperFirst(): void
    {
        self::assertEquals('Foo', Str::upperFirst('foo'));
        self::assertEquals('FOo', Str::upperFirst('fOo'));
        self::assertEquals('Τάχιστη αλώπηξ', Str::upperFirst('τάχιστη αλώπηξ'));
    }

    /* -------------------------------------------------
     * LIMIT
     * -------------------------------------------------
     */

    public function testLimit(): void
    {
        self::assertEquals('Foobar', Str::limit('Foobar'));
        self::assertEquals('Foo...', Str::limit('Foobar', 3));
        self::assertEquals('Foo ->', Str::limit('Foobar', 3, ' ->'));
        self::assertEquals('Τάχιστη αλώπηξ', Str::limit('Τάχιστη αλώπηξ'));
        self::assertEquals('Τάχιστη...', Str::limit('Τάχιστη αλώπηξ', 7));
    }

    public function testLimitSafe(): void
    {
        self::assertEquals('Foo bar', Str::limitSafe('Foo bar'));
        self::assertEquals('Foo...', Str::limitSafe('Foo bar', 5));
        self::assertEquals('Foo ->', Str::limitSafe('Foo bar', 5, ' ->'));
        self::assertEquals('Τάχιστη αλώπηξ', Str::limit('Τάχιστη αλώπηξ'));
        self::assertEquals('Τάχιστη...', Str::limit('Τάχιστη αλώπηξ', 7));
    }

    /* -------------------------------------------------
     * FIRST POS
     * -------------------------------------------------
     */

    public function testFirstPos(): void
    {
        $string = 'Hey foo, what the Foo is going on?';

        self::assertEquals(4, Str::firstPos($string, 'foo'));
        self::assertEquals(18, Str::firstPos($string, 'Foo'));
        self::assertEquals(18, Str::firstPos($string, 'Foo', 5));
        self::assertEquals(4, Str::firstPos($string, 'Foo', 0, false));
        self::assertEquals(8, Str::firstPos('Τάχιστη αλώπηξ', 'αλώπηξ'));

        self::assertFalse(Str::firstPos($string, 'nope'));
        self::assertFalse(Str::firstPos($string, ''));
    }

    /* -------------------------------------------------
     * LAST POST
     * -------------------------------------------------
     */

    public function testLastPos(): void
    {
        $string = 'Hey foo, what the foo is going on?';

        self::assertEquals(18, Str::lastPos($string, 'foo'));
        self::assertEquals(31, Str::lastPos('Hey foo, what the Foo is going foo?', 'Foo', 0, false));
        self::assertEquals(8, Str::lastPos('Τάχιστη αλώπηξ', 'αλώπηξ'));

        self::assertFalse(Str::lastPos($string, 'Foo', 18));
    }

    /* -------------------------------------------------
     * REPLACE
     * -------------------------------------------------
     */

    public function testReplace(): void
    {
        self::assertEquals('bar', Str::replace('foo', 'f[o]+', 'bar'));
        self::assertEquals('o bar', Str::replace('foo bar', 'f(o)o', '\1'));
        self::assertEquals('bar', Str::replace('foo bar', 'f[O]+\s', '', 'i'));
        self::assertEquals('foo', Str::replace('bar', '[[:alpha:]]{3}', 'foo'));
        self::assertEquals('', Str::replace('', '', ''));
        self::assertEquals('αλώπηξ', Str::replace('Τάχιστη ', 'Τ[άχιστη]+\s', 'αλώπηξ'));
    }

    /* -------------------------------------------------
     * STRIP WHITESPACE
     * -------------------------------------------------
     */

    public function testStripWhitespace(): void
    {
        self::assertEquals('Foobar', Str::stripWhitespace('Foo bar'));
        self::assertEquals('Foobar', Str::stripWhitespace('  Foo   bar  '));
        self::assertEquals('Τάχιστηαλώπηξ', Str::stripWhitespace('Τάχιστη αλώπηξ'));
        self::assertEquals('', Str::stripWhitespace(' '));
    }

    /* -------------------------------------------------
     * INSERT
     * -------------------------------------------------
     */

    public function testInsert(): void
    {
        self::assertEquals('foo', Str::insert('oo', 'f', 0));
        self::assertEquals('foobar', Str::insert('foo', 'bar', 3));
        self::assertEquals('foobar', Str::insert('foobar', 'baz', 7));
        self::assertEquals('Τάχιστη αλώπηξ', Str::insert('Τάχιστη ', 'αλώπηξ', 8));
    }

    /* -------------------------------------------------
     * EQUALS
     * -------------------------------------------------
     */

    public function testEquals(): void
    {
        self::assertTrue(Str::equals('Case sensitive', 'Case sensitive'));
        self::assertTrue(Str::equals('Case insensitive', 'case insensitive', false));
        self::assertTrue(Str::equals('Τάχιστη αλώπηξ', 'Τάχιστη αλώπηξ'));

        self::assertFalse(Str::equals('Case sensitive', 'case sensitive'));
    }

    /* -------------------------------------------------
     * LENGTH
     * -------------------------------------------------
     */

    public function testLength(): void
    {
        self::assertEquals(3, Str::length('Foo'));
        self::assertEquals(14, Str::length('Τάχιστη αλώπηξ'));
    }

    /* -------------------------------------------------
     * ESCAPE
     * -------------------------------------------------
     */

    public function testEscape(): void
    {
        $actual = '<h1>Hello world</h1>';
        $expected = '&lt;h1&gt;Hello world&lt;/h1&gt;';

        self::assertEquals($expected, Str::escape($actual));
    }

    /* -------------------------------------------------
     * TITLE
     * -------------------------------------------------
     */

    public function testTitle(): void
    {
        self::assertEquals('Hello World', Str::title('hello world'));
        self::assertEquals('Τάχιστη Αλώπηξ', Str::title('Τάχιστη αλώπηξ'));
    }

    /* -------------------------------------------------
     * SLUG
     * -------------------------------------------------
     */

    public function testSlug(): void
    {
        self::assertEquals('hello-world', Str::slug('Hello World'));
        self::assertEquals('hello-world', Str::slug('Hello-World'));
        self::assertEquals('hello-world', Str::slug('Hello_World'));
        self::assertEquals('hello_world', Str::slug('Hello_World', '_'));
        self::assertEquals('taxisth-alwphx-100-00', Str::slug('- Τάχιστη αλώπηξ - 100,00 € -'));
    }

    /* -------------------------------------------------
     * STUDLY
     * -------------------------------------------------
     */

    public function testStudly(): void
    {
        self::assertEquals('ShoEboX', Str::studly('Sho-ebo-x'));
        self::assertEquals('ShoEboX', Str::studly('Sho-Ebo-x'));
        self::assertEquals('ShoEboX', Str::studly('Sho-Ebo-X'));
        self::assertEquals('ShoEboX', Str::studly('Sho -_- ebo -_ - x'));
        self::assertEquals('ΤάχιστηΑλώπηξ', Str::studly('Τάχιστη-αλώπηξ'));
    }

    /* -------------------------------------------------
     * CAMEL CASE
     * -------------------------------------------------
     */

    public function testCamel(): void
    {
        self::assertEquals('helloWorldWhatsUp', Str::camel('Hello world-whats up'));
        self::assertEquals('helloWorldWhatsUp', Str::camel('Hello world - whats up'));
        self::assertEquals('helloWorldWhatsUp', Str::camel('Hello world-Whats up'));
        self::assertEquals('helloWorldWhatsUp', Str::camel('Hello world -_- whats up'));
        self::assertEquals('τάχιστηΑλώπηξ', Str::camel('Τάχιστη Αλώπηξ'));
    }

    /* -------------------------------------------------
     * SNAKE
     * -------------------------------------------------
     */

    public function testSnake(): void
    {
        self::assertEquals('hello_world', Str::snake('HelloWorld'));
        self::assertEquals('hello_world', Str::snake('Hello World'));
        self::assertEquals('hello-world', Str::snake('Hello World', '-'));
        self::assertEquals('τάχιστη_αλώπηξ', Str::snake('Τάχιστη Αλώπηξ'));
    }
}
