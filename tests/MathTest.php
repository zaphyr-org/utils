<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use stdClass;
use Zaphyr\Utils\Math;

class MathTest extends TestCase
{
    /* -------------------------------------------------
     * ROUND
     * -------------------------------------------------
     */

    /**
     * @param numeric $expected
     * @param numeric $result
     * @param int     $precision
     * @param int     $round
     *
     * @dataProvider validRoundDataProvider
     */
    public function testRoundReturnsTrue($expected, $result, int $precision = 2, int $round = Math::ROUND_UP): void
    {
        self::assertEquals($expected, Math::round($result, $precision, $round));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidFloatDataProvider
     */
    public function testRoundReturnsFalse($value): void
    {
        self::assertFalse(Math::round($value));
        self::assertFalse(Math::round(1, 2, 999));
    }

    /**
     * @return array<string, array<string, numeric>>
     */
    public function validRoundDataProvider(): array
    {
        return [
            // round up
            'up_zero' => [
                'expected' => 0.0,
                'result' => 0,
            ],
            'up_int' => [
                'expected' => 1.0,
                'result' => 1,
            ],
            'up_string' => [
                'expected' => 1.0,
                'result' => '1',
            ],
            'up_round_int_standard_precision' => [
                'expected' => 1.62,
                'result' => 1.611,
            ],
            'up_round_int_custom_precision' => [
                'expected' => 1.7,
                'result' => 1.61,
                'precision' => 1,
            ],

            // round down
            'down_zero' => [
                'expected' => 0.0,
                'result' => 0,
                'precision' => 2,
                'round' => Math::ROUND_DOWN,
            ],
            'down_int' => [
                'expected' => 1.0,
                'result' => 1,
                'precision' => 2,
                'round' => Math::ROUND_DOWN,
            ],
            'down_string' => [
                'expected' => 1.0,
                'result' => '1',
                'precision' => 2,
                'round' => Math::ROUND_DOWN,
            ],
            'down_round_int_standard_precision' => [
                'expected' => 1.45,
                'result' => 1.455555,
                'precision' => 2,
                'round' => Math::ROUND_DOWN,
            ],
            'down_round_int_custom_precision' => [
                'expected' => 1.6,
                'result' => 1.64444,
                'precision' => 1,
                'round' => Math::ROUND_DOWN,
            ],
        ];
    }

    /* -------------------------------------------------
     * AVERAGE
     * -------------------------------------------------
     */

    /**
     * @param numeric $expected
     * @param numeric $result
     * @param int     $precision
     * @param int     $round
     *
     * @dataProvider validAverageDataProvider
     */
    public function testAverageReturnsFloat($expected, $result, int $precision = 2, int $round = Math::ROUND_UP): void
    {
        self::assertEquals($expected, Math::average($result, $precision, $round));
    }

    /**
     * @param numeric $value
     *
     * @dataProvider invalidFloatDataProvider
     */
    public function testAverageReturnsFalse($value): void
    {
        self::assertFalse(Math::average([$value]));
        self::assertFalse(Math::average([1, 2], 2, 999));
    }

    /**
     * @return array<string, array<string, numeric>>
     */
    public function validAverageDataProvider(): array
    {
        return [
            'int' => [
                'expected' => 3.0,
                'result' => [1, 3, 5],
            ],
            'string' => [
                'expected' => 3.0,
                'result' => ['1', '3', '5'],
            ],
            'round_up' => [
                'expected' => 3.2,
                'result' => [1.54, 2.65, 5.40],
            ],
            'round_down' => [
                'expected' => 3.19,
                'result' => [1.54, 2.65, 5.40],
                'precision' => 2,
                'round' => Math::ROUND_DOWN,
            ],
            'round_down_custom_precision' => [
                'expected' => 3.0,
                'result' => [1.54, 2.65, 5.40],
                'precision' => 0,
                'round' => Math::ROUND_DOWN,
            ],
        ];
    }

    /* -------------------------------------------------
     * PERCENTAGE
     * -------------------------------------------------
     */

    /**
     * @param numeric $expected
     * @param numeric $percentage
     * @param numeric $total
     * @param int     $precision
     * @param int     $round
     *
     * @dataProvider validPercentageDataProvider
     */
    public function testCalculatePercentageReturnsFloat(
        $expected,
        $percentage,
        $total,
        int $precision = 2,
        int $round = Math::ROUND_UP
    ): void {
        self::assertEquals($expected, Math::percentage($percentage, $total, $precision, $round));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidFloatDataProvider
     */
    public function testCalculatePercentageReturnsFalse($value): void
    {
        self::assertFalse(Math::percentage($value, 10));
        self::assertFalse(Math::percentage(0, $value));
        self::assertFalse(Math::percentage(0, 0));
        self::assertFalse(Math::percentage('foo-25', '0bar500'));
        self::assertFalse(Math::percentage(0, 20, 2, 999));
    }

    /**
     * @return array<string, array<string, numeric>>
     */
    public function validPercentageDataProvider(): array
    {
        return [
            'int' => [
                'expected' => 8,
                'percentage' => 40,
                'total' => 20,
            ],
            'string' => [
                'expected' => 8,
                'percentage' => '40',
                'total' => '20',
            ],
            'mixed' => [
                'expected' => 8,
                'percentage' => 40,
                'total' => '20',
            ],
            'round_up' => [
                'expected' => 1,
                'percentage' => 3.59,
                'total' => 27.5,
                'precision' => 1,
            ],
            'round_down' => [
                'expected' => 0.9,
                'percentage' => 3.59,
                'total' => 27.5,
                'precision' => 1,
                'round' => Math::ROUND_DOWN,
            ],
        ];
    }

    /* -------------------------------------------------
     * ORDINAL
     * -------------------------------------------------
     */

    /**
     * @param numeric $expected
     * @param numeric $result
     *
     * @dataProvider validOrdinalsDataProvider
     */
    public function testOrdinalReturnsFloat($expected, $result): void
    {
        self::assertEquals($expected, Math::ordinal($result));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidIntegerDataProvider
     */
    public function testOrdinalReturnsFalse($value): void
    {
        self::assertFalse(Math::ordinal($value));
        self::assertFalse(Math::ordinal(0));
        self::assertFalse(Math::ordinal(-1));
    }

    /**
     * @return array<string, numeric>
     */
    public function validOrdinalsDataProvider(): array
    {
        return [
            ['1st', 1],
            ['2nd', 2],
            ['3rd', '3'],
            ['4th', 4],
            ['5th', 5],
            ['6th', 6],
            ['7th', 7],
            ['8th', 8],
            ['9th', 9],
            ['11th', 11],
            ['13th', 13],
            ['20th', '20'],
            ['22nd', 22],
            ['23rd', 23],
            ['200th', '200'],
            ['211th', 211],
            ['213th', 213],
            ['222nd', 222],
            ['223rd', 223],
        ];
    }

    /* -------------------------------------------------
     * FACULTIES
     * -------------------------------------------------
     */

    /**
     * @param numeric $expected
     * @param numeric $result
     *
     * @dataProvider validFacultiesDataProvider
     */
    public function testFacultyReturnsInteger($expected, $result): void
    {
        self::assertEquals($expected, Math::faculty($result));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidIntegerDataProvider
     */
    public function testFacultyReturnsFalse($value): void
    {
        self::assertFalse(Math::faculty($value));
        self::assertFalse(Math::faculty(-1));
    }

    /**
     * @return array<int, numeric>
     */
    public function validFacultiesDataProvider(): array
    {
        return [
            [0, -1],
            [1, '0'],
            [1, 1],
            [2, 2],
            [6, '3'],
            [24, 4],
            [120, 5],
            [3628800, 10],
            [2432902008176640000, 20],
        ];
    }

    /* -------------------------------------------------
     * COMBINATIONS
     * -------------------------------------------------
     */

    public function testCombinations(): void
    {
        $expected = [
            1 => [1],
            2 => [2],
            3 => [1, 2],
            4 => [3],
            5 => [1, 3],
            6 => [2, 3],
            7 => [1, 2, 3],
        ];

        self::assertEquals($expected, Math::combinations([1, 2, 3]));
    }

    public function testCombinationsWithGivenId(): void
    {
        self::assertEquals([1, 2], Math::combinations([1, 2, 3], 3));
    }

    public function testCombinationsReturnsEmptyArrayIfIdDoesNotExists(): void
    {
        self::assertEquals([], Math::combinations([1], 2));
    }

    /* -------------------------------------------------
     * MIN
     * -------------------------------------------------
     */

    public function testMin(): void
    {
        self::assertEquals(20, Math::min(10, 20));
        self::assertEquals(20, Math::min(19.9, 20));
        self::assertEquals(20, Math::min(20, 10));
        self::assertFalse(Math::min('invalid', 0));
    }

    /* -------------------------------------------------
     * MAX
     * -------------------------------------------------
     */

    public function testMax(): void
    {
        self::assertEquals(-10, Math::max(-10, 20));
        self::assertEquals(10, Math::max(10, 50));
        self::assertEquals(49.9, Math::max(49.9, 50));
        self::assertEquals(20, Math::max(30, 20));
        self::assertFalse(Math::max('invalid', 0));
    }

    /* -------------------------------------------------
     * IS INTEGER
     * -------------------------------------------------
     */

    /**
     * @param numeric $value
     *
     * @dataProvider validIntegerDataProvider
     */
    public function testIsIntegerReturnsTrue($value): void
    {
        self::assertTrue(Math::isInteger($value));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidIntegerDataProvider
     */
    public function testIsIntegerReturnsFalse($value): void
    {
        self::assertFalse(Math::isInteger($value));
    }

    /**
     * @return array<string, array<numeric>>
     */
    public function validIntegerDataProvider(): array
    {
        return [
            'zero' => [0],
            'zero_string' => ['0'],
            'int' => [1],
            'int_negative' => [-1],
            'int_max' => [PHP_INT_MAX],
            'string' => ['123456789'],
        ];
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function invalidIntegerDataProvider(): array
    {
        return [
            'string_leading_zero' => ['012'],
            'string_plus_modifier' => ['+12'],
            'string_leading_zero_negative_modifier' => ['-01'],
            'to_large' => [PHP_INT_MAX + 1],
            'string' => ['invalid'],
            'string_empty' => [''],
            'string_int' => ['1 foo'],
            'space_before' => [' 1'],
            'space_after' => ['1 '],
            'tab_before' => ['  1'],
            'tab_after' => ['1  '],
            'float' => [1.20],
            'float_negative' => [-1.20],
            'float_string' => ['1.20'],
            'string_trailing_dot' => ['10.'],
            'null' => [null],
            'array' => [[]],
            'object' => [new stdClass],
        ];
    }

    /* -------------------------------------------------
     * IS FLOAT
     * -------------------------------------------------
     */

    /**
     * @param numeric $value
     *
     * @dataProvider validFloatDataProvider
     */
    public function testIsFloatReturnsTrue($value): void
    {
        self::assertTrue(Math::isFloat($value));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidFloatDataProvider
     */
    public function testIsFloatReturnsFalse($value): void
    {
        self::assertFalse(Math::isFloat($value));
    }

    /**
     * @return array<string, array<numeric>>
     */
    public function validFloatDataProvider(): array
    {
        return [
                'float' => [1.20],
                'float_negative' => [-1.20],
                'float_zero' => [0.00],
                'float_string' => ['-1.20'],
                'string_trailing_dot' => ['10.'],
                'string_trailing_zero' => ['10.0'],
                'string_trailing_zeros' => ['10.00'],
                'float_negative_expo' => [-1.2e3],
                'string_negative_expo' => ['-1.2e03'],
            ] + $this->validIntegerDataProvider();
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function invalidFloatDataProvider(): array
    {
        return [
            'string' => ['invalid'],
            'string_empty' => [''],
            'string_int' => ['1 foo'],
            'space_before' => [' 1'],
            'space_after' => ['1 '],
            'tab_before' => ['  1'],
            'tab_after' => ['1  '],
            'null' => [null],
            'array' => [[]],
            'object' => [new stdClass],
        ];
    }

    /* -------------------------------------------------
     * IS IN RANGE
     * -------------------------------------------------
     */

    /**
     * @param mixed $value
     * @param int   $min
     * @param int   $max
     *
     * @dataProvider validRangesDataProvider
     */
    public function testIsInRangeReturnsTrue($value, int $min, int $max): void
    {
        self::assertTrue(Math::isInRange($value, $min, $max));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidFloatDataProvider
     */
    public function testIsInRangeReturnsFalse($value): void
    {
        self::assertFalse(Math::isInRange($value, 0, 2));
        self::assertFalse(Math::isInRange(100, 0, 2));
    }

    /**
     * @return array{int, int, int}
     */
    public function validRangesDataProvider(): array
    {
        return [
            [1, 1, 2],
            [2, 1, 2],
            [50, 1, 100],
            [1.1, 1, 2],
        ];
    }

    /* -------------------------------------------------
     * IS OUT OF RANGE
     * -------------------------------------------------
     */

    public function testIsOutOfRange(): void
    {
        self::assertTrue(Math::isOutOfRange(10, 11, 20));
        self::assertTrue(Math::isOutOfRange(9.9, 10, 20));
        self::assertFalse(Math::isOutOfRange(10, 9, 11));
        self::assertFalse(Math::isOutOfRange('', 1, 2));
    }

    /* -------------------------------------------------
     * IS EVEN
     * -------------------------------------------------
     */

    public function testIsEven(): void
    {
        self::assertTrue(Math::isEven(20));
        self::assertTrue(Math::isEven(0.5));
        self::assertFalse(Math::isEven(21));
        self::assertFalse(Math::isEven(''));
    }

    /* -------------------------------------------------
     * IS ODD
     * -------------------------------------------------
     */

    public function testIsOdd(): void
    {
        self::assertTrue(Math::isOdd(21));
        self::assertTrue(Math::isOdd(21.25));
        self::assertFalse(Math::isOdd(22));
        self::assertFalse(Math::isOdd(''));
    }

    /* -------------------------------------------------
     * IS POSITIVE
     * -------------------------------------------------
     */

    public function testIsPositive(): void
    {
        self::assertTrue(Math::isPositive(1));
        self::assertTrue(Math::isPositive(0.5));
        self::assertTrue(Math::isPositive(0));
        self::assertFalse(Math::isPositive(0, false));
        self::assertFalse(Math::isPositive(''));
    }

    /* -------------------------------------------------
     * IS NEGATIVE
     * -------------------------------------------------
     */

    public function testIsNegative(): void
    {
        self::assertTrue(Math::isNegative(-1));
        self::assertTrue(Math::isNegative(-0.5));
        self::assertFalse(Math::isNegative(0));
        self::assertFalse(Math::isNegative(''));
    }
}
