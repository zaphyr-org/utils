<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests;

use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Exceptions\UtilsException;
use Zaphyr\Utils\Template;

class TemplateTest extends TestCase
{
    public function testRender(): void
    {
        self::assertEquals(
            "<p>foo</p>\n",
            Template::render(__DIR__ . '/TestAssets/template.html', ['value' => 'foo'])
        );
    }

    public function testRenderEscape(): void
    {
        self::assertEquals(
            "<p>&lt;script&gt;alert(&quot;Hello, world!&quot;);&lt;/script&gt;</p>\n",
            Template::render(
                __DIR__ . '/TestAssets/template.html',
                ['value' => '<script>alert("Hello, world!");</script>']
            )
        );
    }

    public function testRenderWithoutData(): void
    {
        self::assertEquals(
            "<p>%value%</p>\n",
            Template::render(__DIR__ . '/TestAssets/template.html')
        );
    }

    public function testRenderThrowsExceptionWhenTemplateNotFound(): void
    {
        $this->expectException(UtilsException::class);

        Template::render('/not/existing/template.html');
    }

    public function testRenderThrowsExceptionWhenTemplateDataIsNoString(): void
    {
        $this->expectException(UtilsException::class);
        Template::render(
            __DIR__ . '/TestAssets/template.html',
            [
                'value' => [
                    'foo' => 'bar',
                ],
            ],
        );
    }
}
