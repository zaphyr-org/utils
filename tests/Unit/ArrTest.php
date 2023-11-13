<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use ArrayObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Zaphyr\Utils\Arr;

class ArrTest extends TestCase
{
    /* -------------------------------------------------
     * ACCESSIBLE
     * -------------------------------------------------
     */

    /**
     * @param mixed $accessible
     *
     * @dataProvider validArrayAccessibleDataProvider
     */
    public function testAccessibleReturnsTrue(mixed $accessible): void
    {
        self::assertTrue(Arr::accessible($accessible));
    }

    /**
     * @param mixed $accessible
     *
     * @dataProvider invalidArrayAccessibleDataProvider
     */
    public function testAccessibleReturnsFalse(mixed $accessible): void
    {
        self::assertFalse(Arr::accessible($accessible));
    }

    /**
     * @return array<string, array<mixed>>
     */
    public static function validArrayAccessibleDataProvider(): array
    {
        return [
            'empty-array' => [[]],
            'simple-array' => [[1, 2]],
            'assoc-array' => [['1' => 1, '2' => 2]],
            'array-access' => [new ArrayObject],
        ];
    }

    /**
     * @return array<string, array<mixed>>
     */
    public static function invalidArrayAccessibleDataProvider(): array
    {
        return [
            'null' => [null],
            'true' => [true],
            'false' => [false],
            'string' => ['foo'],
            'no-array-access' => [new stdClass],
            'array-object' => [(object)['1' => 1, '2' => 2]],
        ];
    }

    /* -------------------------------------------------
     * EXISTS
     * -------------------------------------------------
     */

    public function testExistsReturnsTrue(): void
    {
        self::assertTrue(Arr::exists([1], 0));
        self::assertTrue(Arr::exists([null], 0));
        self::assertTrue(Arr::exists(['1' => 1], '1'));
        self::assertTrue(Arr::exists(new ArrayObject(['1' => 1]), '1'));
    }

    public function testExistsReturnsFalse(): void
    {
        self::assertFalse(Arr::exists([1], 1));
        self::assertFalse(Arr::exists([null], 1));
        self::assertFalse(Arr::exists(['1' => 1], '2'));
        self::assertFalse(Arr::exists(new ArrayObject(['1' => 1]), '2'));
    }

    /* -------------------------------------------------
     * SET
     * -------------------------------------------------
     */

    public function testSetNewKeyValue(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::set($array, 'bar', 'BAR');

        self::assertEquals(['foo' => 'FOO', 'bar' => 'BAR'], $array);
    }

    public function testSetNewNestedKeyValue(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::set($array, 'bar.baz', 'QUX');

        self::assertEquals(['foo' => 'FOO', 'bar' => ['baz' => 'QUX']], $array);
    }

    public function testSetOverwriteExistingValue(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::set($array, 'foo', 'BAR');

        self::assertEquals(['foo' => 'BAR'], $array);
    }

    public function testSetNewArray(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::set($array, ['bar' => 'BAR', 'baz' => 'BAZ']);

        self::assertEquals(['bar' => 'BAR', 'baz' => 'BAZ'], $array);
    }

    public function testSetArrayValueString(): void
    {
        $array = [];
        Arr::set($array, 'foo');

        self::assertEquals(['foo'], $array);
    }

    /* -------------------------------------------------
     * ADD
     * -------------------------------------------------
     */

    public function testAddToExistingArray(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::add($array, 'bar', 'BAR');

        self::assertEquals(['foo' => 'FOO', 'bar' => 'BAR'], $array);
    }

    public function testAddDoesNotOverwriteExistingArrayElements(): void
    {
        $array = ['foo' => 'FOO'];
        Arr::add($array, 'foo', 'BAR');

        self::assertEquals(['foo' => 'FOO'], $array);
    }

    /* -------------------------------------------------
     * GET
     * -------------------------------------------------
     */

    public function testGetReturnsValue(): void
    {
        $array = [
            'user' => 'merloxx',
            'country' => [
                'name' => 'DE',
            ],
        ];

        $arrayObject = new ArrayObject($array);
        $nestedArrayObject = new ArrayObject(['nested' => $arrayObject]);

        // array
        self::assertEquals('merloxx', Arr::get($array, 'user'));
        self::assertEquals('DE', Arr::get($array, 'country.name'));

        // array object
        self::assertEquals('merloxx', Arr::get($arrayObject, 'user'));
        self::assertEquals('DE', Arr::get($arrayObject, 'country.name'));

        // nested array object
        self::assertEquals('merloxx', Arr::get($nestedArrayObject, 'nested.user'));
        self::assertEquals('DE', Arr::get($nestedArrayObject, 'nested.country.name'));
    }

    public function testGetReturnsDefaultValueIfKeyDoesNotExistInArray(): void
    {
        // array
        self::assertNull(Arr::get([], 'user'));
        self::assertEquals('default', Arr::get([], 'user', 'default'));
        self::assertEquals([], Arr::get([], null, 'default'));

        // array object
        self::assertNull(Arr::get(new ArrayObject, 'country.name'));
    }

    /* -------------------------------------------------
     * FIRST
     * -------------------------------------------------
     */

    public function testFirst(): void
    {
        $array = [100, 200, 300,];
        $first = Arr::first(
            $array,
            static function ($value) {
                return $value >= 200;
            }
        );

        self::assertEquals(200, $first);
        self::assertEquals(100, Arr::first($array));

        $first = Arr::first(
            $array,
            static function ($value) {
                return $value > 500;
            }
        );

        self::assertNull($first);
        self::assertNull(Arr::first([]));
    }

    /* -------------------------------------------------
     * LAST
     * -------------------------------------------------
     */

    public function testLast(): void
    {
        $array = [100, 200, 300,];
        $last = Arr::last(
            $array,
            static function ($value) {
                return $value < 300;
            }
        );

        self::assertEquals(200, $last);
        self::assertEquals(300, Arr::last($array));
        self::assertNull(Arr::last([]));

        $last = Arr::last(
            $array,
            static function ($value, $key) {
                return $key < 2;
            }
        );

        self::assertEquals(200, $last);
    }

    /* -------------------------------------------------
     * HAS
     * -------------------------------------------------
     */

    public function testHasReturnsTrue(): void
    {
        $array = [
            'user' => 'merloxx',
            'country' => [
                'name' => 'DE',
            ],
        ];
        $arrayObject = new ArrayObject($array);
        $nestedArrayObject = new ArrayObject(['nested' => $arrayObject]);

        // array
        self::assertTrue(Arr::has($array, 'user'));
        self::assertTrue(Arr::has($array, 'country.name'));

        // array object
        self::assertTrue(Arr::has($arrayObject, 'user'));
        self::assertTrue(Arr::has($arrayObject, 'country.name'));

        // nested array object
        self::assertTrue(Arr::has($nestedArrayObject, 'nested.user'));
        self::assertTrue(Arr::has($nestedArrayObject, 'nested.country.name'));
    }

    public function testHasReturnsFalseIfKeyDoesNotExistInArray(): void
    {
        self::assertFalse(Arr::has([], 'user'));
        self::assertFalse(Arr::has([], 'country.name'));
        self::assertFalse(Arr::has([], []));
        self::assertFalse(Arr::has(new ArrayObject, 'user'));
    }

    /* -------------------------------------------------
     * WHERE
     * -------------------------------------------------
     */

    public function testWhereValue(): void
    {
        $array = [100, '200', 300,];
        $where = Arr::where(
            $array,
            static function ($value) {
                return is_string($value);
            }
        );

        self::assertEquals([1 => 200], $where);

        $where = Arr::where(
            $array,
            static function ($value) {
                return is_int($value);
            }
        );

        self::assertEquals([0 => 100, 2 => 300], $where);
    }

    public function testWhereKey(): void
    {
        $array = ['first' => 1, 2 => 2];
        $where = Arr::where(
            $array,
            static function ($value, $key) {
                return is_numeric($key);
            }
        );

        self::assertEquals([2 => 2], $where);
    }

    /* -------------------------------------------------
     * ONLY
     * -------------------------------------------------
     */

    public function testOnly(): void
    {
        $array = [
            'user' => 'merloxx',
            'country' => [
                'name' => 'DE',
            ],
        ];

        self::assertEquals(['user' => 'merloxx'], Arr::only($array, 'user'));
        self::assertEquals($array, Arr::only($array, ['user', 'country']));
    }

    /* -------------------------------------------------
     * FORGET
     * -------------------------------------------------
     */

    public function testForget(): void
    {
        $array = ['user' => 'merloxx', 'country' => ['name' => 'DE']];
        Arr::forget($array, 'country');

        self::assertEquals(['user' => 'merloxx'], $array);

        $array = ['user' => 'merloxx', 'country' => ['name' => 'DE']];
        Arr::forget($array, 'country.name');

        self::assertEquals(['user' => 'merloxx', 'country' => []], $array);

        $array = ['user' => 'merloxx', 'country' => ['name' => 'DE']];
        Arr::forget($array, []);

        self::assertEquals(['user' => 'merloxx', 'country' => ['name' => 'DE']], $array);

        $array = ['user' => 'merloxx', 'country' => ['name' => 'DE']];
        Arr::forget($array, 'country.flag');

        self::assertEquals(['user' => 'merloxx', 'country' => ['name' => 'DE']], $array);

        $array = [
            'user' => [
                'hello@merloxx.it' => ['name' => 'merloxx'],
                'john@localhost' => ['name' => 'John'],
            ],
        ];

        Arr::forget($array, ['user.hello@merloxx.it', 'user.john@localhost']);

        self::assertEquals(['user' => ['hello@merloxx.it' => ['name' => 'merloxx']]], $array);
    }

    /* -------------------------------------------------
     * EXCEPT
     * -------------------------------------------------
     */

    public function testExcept(): void
    {
        $array = ['name' => 'merloxx', 'age' => 29];

        self::assertEquals(['age' => 29], Arr::except($array, ['name']));
        self::assertEquals(['age' => 29], Arr::except($array, 'name'));

        $array = ['name' => 'merloxx', 'framework' => ['language' => 'PHP', 'name' => 'zaphyr']];

        self::assertEquals(['name' => 'merloxx'], Arr::except($array, 'framework'));
        self::assertEquals(
            ['name' => 'merloxx', 'framework' => ['name' => 'zaphyr']],
            Arr::except($array, 'framework.language')
        );
        self::assertEquals(
            ['framework' => ['language' => 'PHP']],
            Arr::except($array, ['name', 'framework.name'])
        );
    }
}
