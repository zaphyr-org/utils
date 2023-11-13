<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use ArrayIterator;
use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Zaphyr\Utils\Form;

class FormTest extends TestCase
{
    public function tearDown(): void
    {
        Form::close();
    }

    /* -------------------------------------------------
     * OPEN
     * -------------------------------------------------
     */

    public function testOpen(): void
    {
        self::assertEquals('<form accept-charset="UTF-8" method="POST">', Form::open());
    }

    public function testOpenWithMethodAndAction(): void
    {
        self::assertEquals(
            '<form accept-charset="UTF-8" method="GET" action="https://localhost/foo">',
            Form::open(['method' => 'get', 'action' => 'https://localhost/foo'])
        );
    }

    public function testOpenWithIdAndClass(): void
    {
        self::assertEquals(
            '<form accept-charset="UTF-8" method="POST" class="form" id="id-form">',
            Form::open(['method' => 'POST', 'class' => 'form', 'id' => 'id-form'])
        );
    }

    public function testOpenWithCharset(): void
    {
        self::assertEquals(
            '<form accept-charset="UTF-16" method="GET">',
            Form::open(['method' => 'GET', 'accept-charset' => 'UTF-16'])
        );
    }

    public function testOpenWithFiles(): void
    {
        self::assertEquals(
            '<form accept-charset="UTF-16" method="POST" enctype="multipart/form-data">',
            Form::open(['accept-charset' => 'UTF-16', 'files' => true])
        );
    }

    public function testOpenWithSpoofedMethod(): void
    {
        self::assertEquals(
            '<form accept-charset="UTF-8" method="POST"><input name="_method" type="hidden" value="PUT">',
            Form::open(['method' => 'PUT'])
        );
    }

    /* -------------------------------------------------
     * GET METHOD
     * -------------------------------------------------
     */

    public function testGetMethod(): void
    {
        self::assertEquals('GET', Form::getMethod('get'));
        self::assertEquals('POST', Form::getMethod('post'));
    }

    public function testGetMethodReturnsPostOnNonGetMethod(): void
    {
        self::assertEquals('POST', Form::getMethod('DELETE'));
    }

    /* -------------------------------------------------
     * GET ACTION
     * -------------------------------------------------
     */

    public function testGetAction(): void
    {
        self::assertEquals('/foo/bar', Form::getAction(['action' => '/foo/bar']));
    }

    public function testGetActionReturnsNullWhenNoActionOptionExist(): void
    {
        self::assertNull(Form::getAction([]));
    }

    /* -------------------------------------------------
     * CLOSE
     * -------------------------------------------------
     */

    public function testClose(): void
    {
        self::assertEquals('</form>', Form::close());
    }

    /* -------------------------------------------------
     * LABEL
     * -------------------------------------------------
     */

    public function testLabel(): void
    {
        self::assertEquals('<label for="foo_bar">Foo Bar</label>', Form::label('foo_bar'));
        self::assertEquals('<label for="foo-bar">Foo Bar</label>', Form::label('foo-bar'));
    }

    public function testLabelWithValue(): void
    {
        self::assertEquals('<label for="foo">Bar</label>', Form::label('foo', 'Bar'));
    }

    public function testLabelWithOptions(): void
    {
        self::assertEquals(
            '<label for="foo" id="baz">Bar</label>',
            Form::label('foo', 'Bar', ['id' => 'baz'])
        );
    }

    public function testLabelEscapesHtmlByDefault(): void
    {
        self::assertEquals(
            '<label for="foo">&lt;span&gt;Bar&lt;/span&gt;</label>',
            Form::label('foo', '<span>Bar</span>')
        );
    }

    public function testLabelDisableEscaping(): void
    {
        self::assertEquals(
            '<label for="foo"><span>Bar</span></label>',
            Form::label('foo', '<span>Bar</span>', [], false)
        );
    }

    public function testLabelNoDoubleEncoding(): void
    {
        self::assertEquals(
            '<label for="foo">&lt;span&gt;Bar&lt;/span&gt;</label>',
            Form::label('foo', '&lt;span&gt;Bar&lt;/span&gt;')
        );
    }

    /* -------------------------------------------------
     * INPUT
     * -------------------------------------------------
     */

    public function testInput(): void
    {
        self::assertEquals('<input name="foo" type="text">', Form::input('text', 'foo'));
    }

    public function testInputWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="text" value="bar">',
            Form::input('text', 'foo', 'bar')
        );
    }

    public function testInputWithClass(): void
    {
        self::assertEquals(
            '<input class="bar" name="foo" type="date">',
            Form::input('date', 'foo', null, ['class' => 'bar'])
        );
    }

    public function testInputWithBooleanValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="checkbox" value="1">',
            Form::input('checkbox', 'foo', true)
        );
    }

    public function testInputWithIdOption(): void
    {
        self::assertEquals(
            '<input id="foo" name="foo" type="text">',
            Form::input('text', 'foo', null, ['id' => 'foo'])
        );
    }

    public function testInputTextArray(): void
    {
        self::assertEquals('<input name="foo[bar]" type="text">', Form::input('text', 'foo[bar]'));
    }

    public function testAddIdToInputFieldIfLabelExists(): void
    {
        Form::label('foo', 'Foo');

        self::assertEquals(
            '<input name="foo" type="text" id="foo">',
            Form::input('text', 'foo')
        );
    }

    /* -------------------------------------------------
     * TEXT
     * -------------------------------------------------
     */

    public function testText(): void
    {
        self::assertEquals('<input name="foo" type="text">', Form::text('foo'));
    }

    public function testTextWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="text" value="bar">',
            Form::text('foo', 'bar')
        );
    }

    public function testTextWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="text">',
            Form::text('foo', null, ['class' => 'baz'])
        );
    }

    public function testFormTextArray(): void
    {
        self::assertEquals('<input name="foo[bar]" type="text">', Form::text('foo[bar]'));
    }

    /* -------------------------------------------------
     * PASSWORD
     * -------------------------------------------------
     */

    public function testPassword(): void
    {
        self::assertEquals('<input name="foo" type="password" value="">', Form::password('foo'));
    }

    public function testPasswordWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="password" value="">',
            Form::password('foo', ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * TEXT
     * -------------------------------------------------
     */

    public function testRange(): void
    {
        self::assertEquals('<input name="foo" type="range">', Form::range('foo'));
    }

    public function testRangeWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="range" value="1">',
            Form::range('foo', '1')
        );
    }

    public function testRangeWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="range">',
            Form::range('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * HIDDEN
     * -------------------------------------------------
     */

    public function testHidden(): void
    {
        self::assertEquals('<input name="foo" type="hidden">', Form::hidden('foo'));
    }

    public function testHiddenWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="hidden" value="bar">',
            Form::hidden('foo', 'bar')
        );
    }

    public function testHiddenWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="hidden">',
            Form::hidden('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * SEARCH
     * -------------------------------------------------
     */

    public function testSearch(): void
    {
        self::assertEquals('<input name="foo" type="search">', Form::search('foo'));
    }

    public function testSearchWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="search" value="bar">',
            Form::search('foo', 'bar')
        );
    }

    public function testSearchWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="search">',
            Form::search('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * EMAIL
     * -------------------------------------------------
     */

    public function testEmail(): void
    {
        self::assertEquals('<input name="foo" type="email">', Form::email('foo'));
    }

    public function testEmailWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="email" value="foo@bar.com">',
            Form::email('foo', 'foo@bar.com')
        );
    }

    public function testEmailWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="email">',
            Form::email('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * TEL
     * -------------------------------------------------
     */

    public function testTel(): void
    {
        self::assertEquals('<input name="foo" type="tel">', Form::tel('foo'));
    }

    public function testTelWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="tel" value="1234">',
            Form::tel('foo', '1234')
        );
    }

    public function testTelWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="tel">',
            Form::tel('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * NUMBER
     * -------------------------------------------------
     */

    public function testNumber(): void
    {
        self::assertEquals('<input name="foo" type="number">', Form::number('foo'));
    }

    public function testNumberWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="number" value="1234">',
            Form::number('foo', '1234')
        );
    }

    public function testNumberWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="number">',
            Form::Number('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * DATE
     * -------------------------------------------------
     */

    public function testDate(): void
    {
        self::assertEquals('<input name="foo" type="date">', Form::date('foo'));
    }

    public function testDateWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="date" value="1989-12-19">',
            Form::date('foo', '1989-12-19')
        );
    }

    public function testDateWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="date" value="' . (new DateTime())->format('Y-m-d') . '">',
            Form::date('foo', new DateTime())
        );
    }

    public function testDateWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="date">',
            Form::date('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * DATETIME
     * -------------------------------------------------
     */

    public function testDatetime(): void
    {
        self::assertEquals('<input name="foo" type="datetime">', Form::datetime('foo'));
    }

    public function testDatetimeWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="datetime" value="1989-12-19T05:04:00+00:00">',
            Form::datetime('foo', '1989-12-19T05:04:00+00:00')
        );
    }

    public function testDatetimeWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="datetime" value="' . (new DateTime())->format(DateTimeInterface::RFC3339) . '">',
            Form::datetime('foo', new DateTime())
        );
    }

    public function testDatetimeWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="datetime">',
            Form::datetime('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * DATETIME LOCAL
     * -------------------------------------------------
     */

    public function testDatetimeLocal(): void
    {
        self::assertEquals('<input name="foo" type="datetime-local">', Form::datetimeLocal('foo'));
    }

    public function testDatetimeLocalWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="datetime-local" value="1989-12-19T05:04">',
            Form::datetimeLocal('foo', '1989-12-19T05:04')
        );
    }

    public function testDatetimeLocalWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="datetime-local" value="' . (new DateTime())->format('Y-m-d\TH:i') . '">',
            Form::datetimeLocal('foo', new DateTime())
        );
    }

    public function testDatetimeLocalWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="datetime-local">',
            Form::datetimeLocal('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * TIME
     * -------------------------------------------------
     */

    public function testTime(): void
    {
        self::assertEquals('<input name="foo" type="time">', Form::time('foo'));
    }

    public function testTimeWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="time" value="05:04">',
            Form::time('foo', '05:04')
        );
    }

    public function testTimeWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="time" value="' . (new DateTime())->format('H:i') . '">',
            Form::time('foo', new DateTime())
        );
    }

    public function testTimeWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="time">',
            Form::time('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * WEEK
     * -------------------------------------------------
     */

    public function testWeek(): void
    {
        self::assertEquals('<input name="foo" type="week">', Form::week('foo'));
    }

    public function testWeekWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="week" value="2019-W12">',
            Form::week('foo', '2019-W12')
        );
    }

    public function testWeekWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="week" value="' . (new DateTime())->format('Y-\WW') . '">',
            Form::week('foo', new DateTime())
        );
    }

    public function testWeekWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="week">',
            Form::week('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * MONTH
     * -------------------------------------------------
     */

    public function testMonth(): void
    {
        self::assertEquals('<input name="foo" type="month">', Form::month('foo'));
    }

    public function testMonthWithValueString(): void
    {
        self::assertEquals(
            '<input name="foo" type="month" value="2019-03">',
            Form::month('foo', '2019-03')
        );
    }

    public function testMonthWithDateTimeInstance(): void
    {
        self::assertEquals(
            '<input name="foo" type="month" value="' . (new DateTime())->format('Y-m') . '">',
            Form::month('foo', new DateTime())
        );
    }

    public function testMonthWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="month">',
            Form::month('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * URL
     * -------------------------------------------------
     */

    public function testUrl(): void
    {
        self::assertEquals('<input name="foo" type="url">', Form::url('foo'));
    }

    public function testUrlWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="url" value="https://localhost">',
            Form::url('foo', 'https://localhost')
        );
    }

    public function testUrlWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="url">',
            Form::url('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * FILE
     * -------------------------------------------------
     */

    public function testFile(): void
    {
        self::assertEquals('<input name="foo" type="file">', Form::file('foo'));
    }

    public function testFileWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="file">',
            Form::file('foo', ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * IMAGE
     * -------------------------------------------------
     */

    public function testImage(): void
    {
        self::assertEquals(
            '<input src="https://localhost/foo.jpg" name="foo" type="image">',
            Form::image('foo', 'https://localhost/foo.jpg')
        );
    }

    public function testImageWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" src="https://localhost/foo.jpg" name="foo" type="image">',
            Form::image('foo', 'https://localhost/foo.jpg', ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * COLOR
     * -------------------------------------------------
     */

    public function testColor(): void
    {
        self::assertEquals('<input name="foo" type="color">', Form::color('foo'));
    }

    public function testColorWithValue(): void
    {
        self::assertEquals(
            '<input name="foo" type="color" value="#ffffff">',
            Form::color('foo', '#ffffff')
        );
    }

    public function testColorWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="color">',
            Form::color('foo', null, ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * RESET
     * -------------------------------------------------
     */

    public function testReset(): void
    {
        self::assertEquals('<input type="reset" value="Reset">', Form::reset('Reset'));
    }

    public function testResetWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" type="reset" value="Reset">',
            Form::reset('Reset', ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * SUBMIT
     * -------------------------------------------------
     */

    public function testSubmit(): void
    {
        self::assertEquals('<input type="submit" value="Submit">', Form::submit('Submit'));
    }

    public function testSubmitWithOptions(): void
    {
        self::assertEquals(
            '<input class="baz" type="submit" value="Submit">',
            Form::submit('Submit', ['class' => 'baz'])
        );
    }

    /* -------------------------------------------------
     * BUTTON
     * -------------------------------------------------
     */

    public function testButton(): void
    {
        self::assertEquals('<button type="button">Submit</button>', Form::button('Submit'));
    }

    public function testButtonWithOptions(): void
    {
        self::assertEquals(
            '<button class="baz" type="submit">Submit</button>',
            Form::button('Submit', ['class' => 'baz', 'type' => 'submit'])
        );
    }

    /* -------------------------------------------------
     * CHECKBOX
     * -------------------------------------------------
     */

    public function testInputCheckbox(): void
    {
        self::assertEquals('<input name="foo" type="checkbox">', Form::input('checkbox', 'foo'));
    }

    public function testCheckbox(): void
    {
        self::assertEquals('<input name="foo" type="checkbox" value="1">', Form::checkbox('foo'));
    }

    public function testCheckboxChecked(): void
    {
        self::assertEquals(
            '<input checked="checked" name="foo" type="checkbox" value="bar">',
            Form::checkbox('foo', 'bar', true)
        );
    }

    public function testCheckboxWithValue(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="checkbox" value="bar">',
            Form::checkbox('foo', 'bar', false, ['class' => ['baz']])
        );
    }

    public function testCheckboxMulticheck(): void
    {
        self::assertEquals(
            '<input checked="checked" name="multicheck[id]" type="checkbox" value="1">',
            Form::checkbox('multicheck[id]', 1, true)
        );
        self::assertEquals(
            '<input name="multicheck[id]" type="checkbox" value="2">',
            Form::checkbox('multicheck[id]', 2)
        );
        self::assertEquals(
            '<input checked="checked" name="multicheck[id]" type="checkbox" value="3">',
            Form::checkbox('multicheck[id]', 3, true)
        );
    }

    /* -------------------------------------------------
     * RADIO
     * -------------------------------------------------
     */

    public function testInputRadio(): void
    {
        self::assertEquals('<input name="foo" type="radio">', Form::input('radio', 'foo'));
    }

    public function testRadio(): void
    {
        self::assertEquals('<input name="foo" type="radio" value="foo">', Form::radio('foo'));
    }

    public function testRadioChecked(): void
    {
        self::assertEquals(
            '<input checked="checked" name="foo" type="radio" value="bar">',
            Form::radio('foo', 'bar', true)
        );
    }

    public function testRadioWithValue(): void
    {
        self::assertEquals(
            '<input class="baz" name="foo" type="radio" value="bar">',
            Form::radio('foo', 'bar', false, ['class' => ['baz']])
        );
    }

    /* -------------------------------------------------
     * TEXTAREA
     * -------------------------------------------------
     */

    public function testTextarea(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="50" rows="10"></textarea>',
            Form::textarea('foo')
        );
    }

    public function testTextareaWithValue(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="50" rows="10">Bar</textarea>',
            Form::textarea('foo', 'Bar')
        );
    }

    public function testTextareaWithEscapedValue(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="50" rows="10">&lt;span&gt;Bar&lt;/span&gt;</textarea>',
            Form::textarea('foo', '<span>Bar</span>')
        );
    }

    public function testTextareaNoDoubleEncoding(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="50" rows="10">&lt;span&gt;Bar&lt;/span&gt;</textarea>',
            Form::textarea('foo', '&lt;span&gt;Bar&lt;/span&gt;')
        );
    }

    public function testTextareaDisableEncoding(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="50" rows="10"><span>Bar</span></textarea>',
            Form::textarea('foo', '<span>Bar</span>', [], false)
        );
    }

    public function testTextareaWithOptions(): void
    {
        self::assertEquals(
            '<textarea class="baz" name="foo" cols="50" rows="10"></textarea>',
            Form::textarea('foo', null, ['class' => 'baz'])
        );
    }

    public function testTextareaWithSizeOption(): void
    {
        self::assertEquals(
            '<textarea name="foo" cols="60" rows="20"></textarea>',
            Form::textarea('foo', null, ['size' => '60x20'])
        );
    }


    public function testTextareaWithColAndRowOptions(): void
    {
        self::assertEquals(
            '<textarea rows="20" cols="60" name="foo"></textarea>',
            Form::textarea('foo', null, ['rows' => 20, 'cols' => 60])
        );
    }

    /* -------------------------------------------------
     * SELECT
     * -------------------------------------------------
     */

    public function testSelect(): void
    {
        self::assertEquals(
            '<select name="foo"></select>',
            Form::select('foo')
        );
    }

    public function testSelectWithOptions(): void
    {
        self::assertEquals(
            '<select name="gender"><option value="0">Male</option><option value="1">Female</option></select>',
            Form::select('gender', ['Male', 'Female'])
        );
    }

    public function testSelectWithNamedOptions(): void
    {
        self::assertEquals(
            '<select name="gender"><option value="m">Male</option><option value="f">Female</option></select>',
            Form::select('gender', ['m' => 'Male', 'f' => 'Female'])
        );
    }

    public function testSelectWithSelectedOption(): void
    {
        self::assertEquals(
            '<select name="gender"><option value="m" selected="selected">Male</option><option value="f">Female</option></select>',
            Form::select('gender', ['m' => 'Male', 'f' => 'Female'], 'm')
        );
    }

    public function testSelectWithSelectedTrueOption(): void
    {
        self::assertEquals(
            '<select name="select"><option value="0" >false</option><option value="1" selected>true</option></select>',
            Form::select('select', ['false', 'true'], true)
        );
    }

    public function testSelectWithMultipleSelectedOption(): void
    {
        self::assertEquals(
            '<select multiple name="gender"><option value="m" selected="selected">Male</option><option value="f" selected="selected">Female</option></select>',
            Form::select('gender', ['m' => 'Male', 'f' => 'Female'], ['m', 'f'], ['multiple'])
        );
    }

    public function testSelectWithSelectOptions(): void
    {
        self::assertEquals(
            '<select class="form-class" id="form-id" name="gender"><option value="m">Male</option><option value="f">Female</option></select>',
            Form::select('gender', ['m' => 'Male', 'f' => 'Female'], null, ['class' => 'form-class', 'id' => 'form-id'])
        );
    }

    public function testSelectWithLabel(): void
    {
        Form::label('select-id');

        self::assertEquals(
            '<select id="select-id" name="select-id"></select>',
            Form::select('select-id')
        );
    }

    public function testSelectWithOptGroup(): void
    {
        self::assertEquals(
            '<select name="size"><optgroup label="Large sizes"><option value="l">Large</option><option value="xl">Extra Large</option></optgroup><option value="s">Small</option></select>',
            Form::select('size', ['Large sizes' => ['l' => 'Large', 'xl' => 'Extra Large'], 's' => 'Small'])
        );
    }

    public function testSelectWithOptGroupDisabledOptions(): void
    {
        self::assertEquals(
            '<select name="size"><optgroup label="Large sizes"><option value="l" disabled>Large</option><option value="xl">Extra Large</option></optgroup><option value="m" disabled>Medium</option><optgroup label="Small sizes" disabled><option value="s">Small</option><option value="xs">Extra Small</option></optgroup></select>',
            Form::select(
                'size',
                [
                    'Large sizes' => ['l' => 'Large', 'xl' => 'Extra Large'],
                    'm' => 'Medium',
                    'Small sizes' => ['s' => 'Small', 'xs' => 'Extra Small'],
                ],
                null,
                [],
                ['Large sizes' => ['l' => ['disabled']], 'm' => ['disabled']],
                ['Small sizes' => ['disabled']]
            )
        );
    }

    public function testSelectWithArrayOptions(): void
    {
        self::assertEquals(
            '<select name="size"><optgroup label="sizes"><optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal"><option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;m</option><option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;l</option></optgroup><optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;large"><option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;xl</option><option value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;xxl</option></optgroup></optgroup></select>',
            Form::select(
                'size',
                [
                    'sizes' => ['normal' => ['m', 'l'], 'large' => ['xl', 'xxl']],
                ]
            )
        );
    }

    public function testSelectEscapesHtml(): void
    {
        self::assertEquals(
            '<select name="foo"><option value="0">&lt;span&gt;Bar&lt;/span&gt;</option></select>',
            Form::select('foo', ['<span>Bar</span>'])
        );
    }

    public function testSelectNoDoubleEncodig(): void
    {
        self::assertEquals(
            '<select name="foo"><option value="0">&lt;span&gt;Bar&lt;/span&gt;</option></select>',
            Form::select('foo', ['&lt;span&gt;Bar&lt;/span&gt;'])
        );
    }

    public function testSelectWithOptionOptions(): void
    {
        self::assertEquals(
            '<select name="gender"><option value="m" data-foo="foo" disabled>Male</option><option value="f">Female</option></select>',
            Form::select(
                'gender',
                ['m' => 'Male', 'f' => 'Female'],
                null,
                [],
                ['m' => ['data-foo' => 'foo', 'disabled']]
            )
        );
    }

    public function testSelectWithPlaceholderOption(): void
    {
        self::assertEquals(
            '<select name="avc"><option disabled="disabled" selected="selected">Choose</option><option value="1">Yes</option><option value="0">No</option></select>',
            Form::select('avc', [1 => 'Yes', 0 => 'No'], null, ['placeholder' => 'Choose'])
        );
    }

    public function testSelectMultiple(): void
    {
        self::assertEquals(
            '<select multiple="multiple" name="size[multi][]"><option value="m">Medium</option><option value="l" selected="selected">Large</option></select>',
            Form::select('size[multi][]', ['m' => 'Medium', 'l' => 'Large'], 'l', ['multiple' => 'multiple'])
        );
    }

    public function testSelectMultipleWithKey(): void
    {
        self::assertEquals(
            '<select name="size[key]"><option value="m">Medium</option><option value="l">Large</option></select>',
            Form::select('size[key]', ['m' => 'Medium', 'l' => 'Large'])
        );
    }

    /* -------------------------------------------------
     * SELECT RANGE
     * -------------------------------------------------
     */

    public function testSelectRange(): void
    {
        self::assertEquals(
            '<select name="year"><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option></select>',
            Form::selectRange('year', 1989, 1991)
        );
    }

    public function testSelectRangeSelected(): void
    {
        self::assertEquals(
            '<select name="year"><option value="1989">1989</option><option value="1990" selected="selected">1990</option><option value="1991">1991</option></select>',
            Form::selectRange('year', 1989, 1991, 1990)
        );
    }

    public function testSelectRangeWithOptions(): void
    {
        self::assertEquals(
            '<select class="form-class" name="year"><option value="1989">1989</option><option value="1990" selected="selected">1990</option><option value="1991">1991</option></select>',
            Form::selectRange('year', 1989, 1991, '1990', ['class' => 'form-class'])
        );
    }

    public function testSelectRangeWithOptionOptions(): void
    {
        self::assertEquals(
            '<select name="year"><option value="1989" data-foo="foo" disabled>1989</option><option value="1990">1990</option><option value="1991">1991</option></select>',
            Form::selectRange('year', 1989, 1991, null, [], ['1989' => ['data-foo' => 'foo', 'disabled']])
        );
    }

    /* -------------------------------------------------
     * DATALIST
     * -------------------------------------------------
     */

    public function testDatalist(): void
    {
        self::assertEquals(
            '<datalist id="genders"><option value="male">male</option><option value="female">female</option></datalist>',
            Form::datalist('genders', ['male', 'female'])
        );
    }

    public function testDatalistWithAssocArray(): void
    {
        self::assertEquals(
            '<datalist id="genders"><option value="m">male</option><option value="f">female</option></datalist>',
            Form::datalist('genders', ['m' => 'male', 'f' => 'female'])
        );
    }

    public function testDatalistWithNumericKeys(): void
    {
        self::assertEquals(
            '<datalist id="genders"><option value="1">male</option><option value="2">female</option></datalist>',
            Form::datalist('genders', [1 => 'male', 2 => 'female'])
        );
    }
}
