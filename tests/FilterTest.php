<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Filter;

class FilterTest extends TestCase
{
    /* -------------------------------------------------
     * ALPHA
     * -------------------------------------------------
     */

    public function testAlpha(): void
    {
        self::assertSame('foo', Filter::alpha('fo-0-o'));
    }

    /* -------------------------------------------------
     * ALPHANUM
     * -------------------------------------------------
     */

    public function testAlphanum(): void
    {
        self::assertEquals('foo123', Filter::alphanum('foo-* 123'));
    }

    /* -------------------------------------------------
     * BASE 64
     * -------------------------------------------------
     */

    public function testBase64(): void
    {
        self::assertEquals(
            'a8O2bGphc2doZHZiYXNua2zDtmzDpMOkYQ==',
            Filter::base64('a8O2bGph*c2do ZHZiYX () Nua2zDtmzDpMOkYQ==')
        );
    }

    /* -------------------------------------------------
     * DIGITS
     * -------------------------------------------------
     */

    public function testDigits(): void
    {
        self::assertEquals(123, Filter::digits('f1o2o3'));
    }

    /* -------------------------------------------------
     * FLOAT
     * -------------------------------------------------
     */

    /**
     * @param float    $expected
     * @param mixed    $actual
     * @param int|null $round
     *
     * @dataProvider floatDataProvider
     */
    public function testFloat(float $expected, $actual, int $round = null): void
    {
        if (null === $round) {
            self::assertSame($expected, Filter::float($actual));
        } else {
            self::assertSame($expected, Filter::float($actual, $round));
        }
    }

    /**
     * @return array{array{float, mixed}}
     */
    public function floatDataProvider(): array
    {
        return [
            [0.0, null],
            [0.0, false],
            [0.0, ''],
            [0.0, 'asdasd'],
            [0.0, 0],
            [1.0, 1],
            [123456789.0, 123456789],
            [1.0, '1'],
            [1.0, '01'],
            [-1.0, '-01'],
            [-10.0, ' - 1 0 '],
            [-1.5, ' - 1,5 '],
            [-1.5, ' - 1.5 '],
            [-1.512, ' - 1.5123 ', 3],
            [-15123.0, ' - 1 asd 5123 ', 3],
            [15123.0, ' + 1 asd 5123 ', 3],
            [-12.451, 'abc-12,451'],
            [-12.452, 'abc-12.452'],
            [-12.453, '-abc12.453'],
            [-12.454, 'abc-12.454abc'],
            [-12.455, 'abc-12. 455'],
            [-12.456, 'abc-12. 456 .7'],
            //[27.3e-34, '27.3e-34'], Failed asserting that 0.0 is identical to 2.73E-33.
        ];
    }

    /* -------------------------------------------------
     * INT
     * -------------------------------------------------
     */

    /**
     * @param int   $expected
     * @param mixed $actual
     *
     * @dataProvider intDataProvider
     */
    public function testInt(int $expected, $actual): void
    {
        self::assertSame($expected, Filter::int($actual));
    }

    /**
     * @return array<int, mixed>
     */
    public function intDataProvider(): array
    {
        return [
            [0, null],
            [0, false],
            [0, ''],
            [0, 0],
            [1, 1],
            [1, '1'],
            [1, '01'],
            [-1, '-01'],
            [-15, ' - 1 5 '],
            [-17, ' - 1 asd 7 '],
            [-1, ' - 1 . 0 '],
            [-1, ' - 1 , 5 '],
            [-1, ' - 1 - 0 '],
            [3, ' + 3'],
            [-4, ' - 4'],
            [-5, ' +- 5'],
            [6, ' -+ 6'],
        ];
    }
}
