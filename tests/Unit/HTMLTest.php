<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\HTML;

class HTMLTest extends TestCase
{
    /* -------------------------------------------------
     * ATTRIBUTES
     * -------------------------------------------------
     */

    public function testAttributes(): void
    {
        self::assertEquals(' foo="bar" baz="qux"', HTML::attributes(['foo' => 'bar', 'baz' => 'qux']));
    }

    public function testAttributesCanReturnEmptyString(): void
    {
        self::assertEquals('', HTML::attributes(['foo' => null]));
    }

    /* -------------------------------------------------
     * ATTRIBUTE ELEMENT
     * -------------------------------------------------
     */

    public function testAttributeElement(): void
    {
        self::assertEquals('foo="bar"', HTML::attributeElement('foo', 'bar'));
    }

    public function testAttributeElementEscapesValue(): void
    {
        self::assertEquals('foo="&lt;h1&gt;bar&lt;/h1&gt;"', HTML::attributeElement('foo', '<h1>bar</h1>'));
    }

    public function testAttributeElementWithNumericKey(): void
    {
        self::assertEquals('1234', HTML::attributeElement('1', '1234'));
    }

    public function testAttributeElementWithBoolValue(): void
    {
        self::assertEquals('isTrue', HTML::attributeElement('isTrue', true));
        self::assertEquals('', HTML::attributeElement('isFalse', false));
    }

    public function testAttributeElementWithArrayClassValues(): void
    {
        self::assertEquals('class="foo bar baz"', HTML::attributeElement('class', ['foo', 'bar', 'baz']));
    }
}
