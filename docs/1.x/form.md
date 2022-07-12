# Form helper

## Table of contents

- [open](#open)
- [getMethod](#getmethod)
- [getAction](#getaction)
- [close](#close)
- [label](#label)
- [input](#input)
- [text](#text)
- [password](#password)
- [range](#range)
- [hidden](#hidden)
- [search](#search)
- [email](#email)
- [tel](#tel)
- [number](#number)
- [date](#date)
- [datetime](#datetime)
- [datetimelocal](#datetimelocal)
- [time](#time)
- [week](#week)
- [month](#month)
- [url](#url)
- [file](#file)
- [image](#image)
- [color](#color)
- [reset](#reset)
- [submit](#submit)
- [button](#button)
- [checkbox](#checkbox)
- [radio](#radio)
- [textarea](#textarea)
- [select](#select)
- [selectRange](#selectrange)
- [datalist](#datalist)

## open

Opens a new form.

```php
use Zaphyr\Utils\Form;

Form::open(); // '<form accept-charset="UTF-8" method="POST">'
Form::open(['method' => 'get', 'action' => 'https://localhost/foo']); // '<form accept-charset="UTF-8" method="GET" action="https://localhost/foo">'
Form::open(['method' => 'POST', 'class' => 'form', 'id' => 'id-form']); // '<form accept-charset="UTF-8" method="POST" class="form" id="id-form">'
Form::open(['method' => 'GET', 'accept-charset' => 'UTF-16']); // '<form accept-charset="UTF-16" method="GET">'
Form::open(['accept-charset' => 'UTF-16', 'files' => true]); // '<form accept-charset="UTF-16" method="POST" enctype="multipart/form-data">'
Form::open(['method' => 'PUT']); // '<form accept-charset="UTF-8" method="POST"><input name="_method" type="hidden" value="PUT">'
```

## getMethod

Returns the method of the form.

```php
use Zaphyr\Utils\Form;

Form::getMethod('get'); // 'GET'
Form::getMethod('DELETE'); // 'POST'
```

## getAction

Returns the action of the form.

```php
use Zaphyr\Utils\Form;

Form::getAction(['action' => '/foo/bar']); // 'foo/bar'
Form::getAction([]); // null
```

## close

Closes a form.

```php
use Zaphyr\Utils\Form;

Form::close(); // '</form>'
```

## label

Returns a label for an input field.

```php
use Zaphyr\Utils\Form;

Form::label('foo-bar'); // <label for="foo-bar">Foo Bar</label>
Form::label('foo', 'Bar'); // '<label for="foo">Bar</label>'
Form::label('foo', 'Bar', ['id' => 'baz']); // '<label for="foo" id="baz">Bar</label>'
Form::label('foo', '<span>Bar</span>'); // '<label for="foo">&lt;span&gt;Bar&lt;/span&gt;</label>'
Form::label('foo', '<span>Bar</span>', [], false); // '<label for="foo"><span>Bar</span></label>'
```

## input

Returns an input field.

```php
use Zaphyr\Utils\Form;

Form::input('text', 'foo'); // '<input name="foo" type="text">'
Form::input('text', 'foo', 'bar'); // '<input name="foo" type="text" value="bar">'
Form::input('date', 'foo', null, ['class' => 'bar']); // '<input class="bar" name="foo" type="date">'
Form::input('checkbox', 'foo', true); // '<input id="foo" name="foo" type="text">'
Form::input('text', 'foo[bar]'); // '<input name="foo[bar]" type="text">'
```

## text

Returns a `text` input field.

```php
use Zaphyr\Utils\Form;

Form::text('foo'); // '<input name="foo" type="text">'
Form::text('foo', 'bar'); // '<input name="foo" type="text" value="bar">'
Form::text('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="text">'
Form::text('foo[bar]'); // '<input name="foo[bar]" type="text">'

```

## password

Returns a `password` input field.

```php
use Zaphyr\Utils\Form;

Form::password('foo'); // <input name="foo" type="password" value="">
Form::password('foo', ['class' => 'baz']); // '<input class="baz" name="foo" type="password" value="">'
```

## range

Returns a `range` input field.

```php
use Zaphyr\Utils\Form;

orm::range('foo'); // <input name="foo" type="range">
Form::range('foo', '1'); // <input name="foo" type="range" value="1">
Form::range('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="range">'
```

## hidden

Returns a `hidden` input field.

```php
use Zaphyr\Utils\Form;

Form::hidden('foo'); // '<input name="foo" type="hidden">'
Form::hidden('foo', 'bar'); // '<input name="foo" type="hidden" value="bar">'
Form::hidden('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="hidden">'
```

## search

Returns a `search` input field.

```php
use Zaphyr\Utils\Form;

Form::search('foo')); // '<input name="foo" type="search">'
Form::search('foo', 'bar'); // '<input name="foo" type="search" value="bar">'
Form::search('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="search">'
```

## email

Returns an `email` input field.

```php
use Zaphyr\Utils\Form;

Form::email('foo'); // '<input name="foo" type="email">'
Form::email('foo', 'foo@bar.com'); // '<input name="foo" type="email" value="foo@bar.com">'
Form::email('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="email">'
```

## tel

Returns a `tel` input field.

```php
use Zaphyr\Utils\Form;

Form::tel('foo')); // '<input name="foo" type="tel">'
Form::tel('foo', '1234'); // '<input name="foo" type="tel" value="1234">'
Form::tel('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="tel">'
```

## number

Returns a `number` input field.

```php
use Zaphyr\Utils\Form;

Form::number('foo'); // '<input name="foo" type="number" value="1234">'
Form::number('foo', '1234'); // '<input name="foo" type="number" value="1234">'
Form::Number('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="number">'
```

## date

Returns a `date` input field.

```php
use Zaphyr\Utils\Form;

Form::date('foo'); // '<input name="foo" type="date">'
Form::date('foo', '1989-12-19'); // '<input name="foo" type="date" value="1989-12-19">'
Form::date('foo', new DateTime('1989-12-19')); // '<input name="foo" type="date" value="1989-12-19">'
```

## datetime

Returns a `datetime` input field.

```php
use Zaphyr\Utils\Form;

Form::datetime('foo'); // '<input name="foo" type="datetime">'
Form::datetime('foo', '1989-12-19T05:04:00+00:00'); // '<input name="foo" type="datetime" value="1989-12-19T05:04:00+00:00">'
Form::datetime('foo', new DateTime(1989-12-19)); // '<input name="foo" type="datetime" value="1989-12-19T00:00:00+01:00">'
Form::datetime('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="datetime">'
```

## datetimelocal

Returns a `datetime-local` input field.

```php
use Zaphyr\Utils\Form;

Form::datetimeLocal('foo'); '<input name="foo" type="datetime-local">'
Form::datetimeLocal('foo', '1989-12-19T05:04'); // '<input name="foo" type="datetime-local" value="1989-12-19T05:04">'
Form::datetimeLocal('foo', new \DateTime('1989-12-19')); // '<input name="foo" type="datetime-local" value="1989-12-19T00:00">'
Form::datetimeLocal('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="datetime-local">'
```

## time

Returns a `time` input field.

```php
use Zaphyr\Utils\Form;

Form::time('foo')); // '<input name="foo" type="time">'
Form::time('foo', '05:04'); // '<input name="foo" type="time" value="05:04">'
Form::time('foo', new DateTime('15:00')); // '<input name="foo" type="time" value="15:00">'
Form::time('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="time">'
```

## week

Returns a `week` input field.

```php
use Zaphyr\Utils\Form;

Form::week('foo'); // '<input name="foo" type="week">'
Form::week('foo', '2019-W12'); // '<input name="foo" type="week" value="2019-W12">'
Form::week('foo', new DateTime('2019-W32')); // '<input name="foo" type="week" value="2019-W32">'
Form::week('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="week">'
```

## month

Returns a `month` input field.

```php
use Zaphyr\Utils\Form;

Form::month('foo'); // '<input name="foo" type="month">'
Form::month('foo', '2019-03'); // '<input name="foo" type="month" value="2019-03">'
Form::month('foo', new DateTime('2019-09')); // '<input name="foo" type="month" value="2019-09">'
Form::month('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="month">'
```

## url

Returns a `url` input field.

```php
use Zaphyr\Utils\Form;

Form::url('foo'); // '<input name="foo" type="url">'
Form::url('foo', 'https://localhost'); // '<input name="foo" type="url" value="https://localhost">'
Form::url('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="url">'
```

## file

Returns a `file` input field.

```php
use Zaphyr\Utils\Form;

Form::file('foo'); // '<input name="foo" type="file">'
Form::file('foo', ['class' => 'baz']); // '<input class="baz" name="foo" type="file">'
```

## image

Returns a `image` input field.

```php
use Zaphyr\Utils\Form;

Form::image('foo', 'https://localhost/foo.jpg'); // '<input src="https://localhost/foo.jpg" name="foo" type="image">'
Form::image('foo', 'https://localhost/foo.jpg', ['class' => 'baz']); // '<input class="baz" src="https://localhost/foo.jpg" name="foo" type="image">'
```

## color

Returns a `color` input field.

```php
use Zaphyr\Utils\Form;

Form::color('foo'); // '<input name="foo" type="color">'
Form::color('foo', '#ffffff'); // '<input name="foo" type="color" value="#ffffff">'
Form::color('foo', null, ['class' => 'baz']); // '<input class="baz" name="foo" type="color">'
```

## reset

Returns a `reset` field.

```php
use Zaphyr\Utils\Form;

Form::reset('Reset'); // '<input type="reset" value="Reset">'
Form::reset('Reset', ['class' => 'baz']); // '<input class="baz" type="reset" value="Reset">'
```

## submit

Returns a `submit` field.

```php
use Zaphyr\Utils\Form;

Form::submit('Submit'); // '<input type="submit" value="Submit">'
Form::submit('Submit', ['class' => 'baz']); // '<input class="baz" type="submit" value="Submit">',
```

## button

Returns a button field.

```php
use Zaphyr\Utils\Form;

Form::button('Submit'); // '<button type="button">Submit</button>'
Form::button('Submit', ['class' => 'baz', 'type' => 'submit']); // '<button class="baz" type="submit">Submit</button>'
```

## checkbox

Returns a checkbox field.

```php
use Zaphyr\Utils\Form;

Form::checkbox('foo'); // '<input name="foo" type="checkbox" value="1">'
Form::checkbox('foo', 'bar', true); // '<input checked="checked" name="foo" type="checkbox" value="bar">',
Form::checkbox('foo', 'bar', false, ['class' => ['baz']]); // '<input class="baz" name="foo" type="checkbox" value="bar">'
```

## radio

Returns a radio field.

```php
use Zaphyr\Utils\Form;

Form::radio('foo'); // '<input name="foo" type="radio" value="foo">'
Form::radio('foo', 'bar', true); // '<input checked="checked" name="foo" type="radio" value="bar">'
Form::radio('foo', 'bar', false, ['class' => ['baz']]); // '<input class="baz" name="foo" type="radio" value="bar">'
```

## textarea

Returns a textarea field.

```php
use Zaphyr\Utils\Form;

Form::textarea('foo'); // '<textarea name="foo" cols="50" rows="10"></textarea>'
Form::textarea('foo', 'Bar'); // '<textarea name="foo" cols="50" rows="10">Bar</textarea>'
Form::textarea('foo', '<span>Bar</span>'); // '<textarea name="foo" cols="50" rows="10">&lt;span&gt;Bar&lt;/span&gt;</textarea>'
Form::textarea('foo', '<span>Bar</span>', [], false); // '<textarea name="foo" cols="50" rows="10"><span>Bar</span></textarea>'
Form::textarea('foo', null, ['class' => 'baz']); // '<textarea class="baz" name="foo" cols="50" rows="10"></textarea>'
Form::textarea('foo', null, ['size' => '60x20']); // '<textarea name="foo" cols="60" rows="20"></textarea>'
Form::textarea('foo', null, ['rows' => 20, 'cols' => 60]); // '<textarea rows="20" cols="60" name="foo"></textarea>'
```

## select

Returns a select field.

```php
use Zaphyr\Utils\Form;

Form::select('foo'); // '<select name="foo"></select>'

Form::select('gender', ['Male', 'Female']);
// <select name="gender">
//      <option value="0">Male</option>
//      <option value="1">Female</option>
//  </select>

Form::select('gender', ['m' => 'Male', 'f' => 'Female']);
// <select name="gender">
//      <option value="m">Male</option>
//      <option value="f">Female</option>
//  </select>

Form::select('gender', ['m' => 'Male', 'f' => 'Female'], 'm');
// <select name="gender">
//      <option value="m" selected="selected">Male</option>
//      <option value="f">Female</option>
//  </select>

Form::select('gender', ['m' => 'Male', 'f' => 'Female'], ['m', 'f'], ['multiple']);
// <select multiple name="gender">
//      <option value="m" selected="selected">Male</option>
//      <option value="f" selected="selected">Female</option>
//  </select>

Form::select('gender', ['m' => 'Male', 'f' => 'Female'], null, ['class' => 'form-class', 'id' => 'form-id']);
// <select class="form-class" id="form-id" name="gender">
//      <option value="m">Male</option>
//      <option value="f">Female</option>
//  </select>

Form::select('size', ['Large sizes' => ['l' => 'Large', 'xl' => 'Extra Large'], 's' => 'Small']);
// <select name="size">
//      <optgroup label="Large sizes">
//          <option value="l">Large</option>
//          <option value="xl">Extra Large</option>
//      </optgroup>
//      <option value="s">Small</option>
//  </select>

Form::select('size', [
    'Large sizes' => ['l' => 'Large', 'xl' => 'Extra Large'],
    'm' => 'Medium',
    'Small sizes' => ['s' => 'Small', 'xs' => 'Extra Small'],
], null, [], ['Large sizes' => ['l' => ['disabled']], 'm' => ['disabled']], ['Small sizes' => ['disabled']]);
//  <select name="size">
//		<optgroup label="Large sizes">
//			<option value="l" disabled>Large</option>
//			<option value="xl">Extra Large</option>
//		</optgroup>
//		<option value="m" disabled>Medium</option>
//		<optgroup label="Small sizes" disabled>
//			<option value="s">Small</option>
//			<option value="xs">Extra Small</option>
//		</optgroup>
//	</select>

Form::select('foo', ['<span>Bar</span>']);
// <select name="foo">
//      <option value="0">&lt;span&gt;Bar&lt;/span&gt;</option>
//  </select>

Form::select(
    'gender',
    ['m' => 'Male', 'f' => 'Female'],
    null,
    [],
    ['m' => ['data-foo' => 'foo', 'disabled']]
);
// <select name="gender">
//      <option value="m" data-foo="foo" disabled>Male</option>
//      <option value="f">Female</option>
//  </select>

Form::select('avc', [1 => 'Yes', 0 => 'No'], true, ['placeholder' => 'Choose']);
// <select name="avc">
//      <option value="">Choose</option>
//      <option value="1" selected>Yes</option>
//      <option value="0" >No</option>
//  </select>

Form::select('size[multi][]', ['m' => 'Medium', 'l' => 'Large'], 'l', ['multiple' => 'multiple']);
// <select multiple="multiple" name="size[multi][]">
//      <option value="m">Medium</option>
//      <option value="l" selected="selected">Large</option>
//  </select>

Form::select('size[key]', ['m' => 'Medium', 'l' => 'Large']);
// <select name="size[key]">
//      <option value="m">Medium</option>
//      <option value="l">Large</option>
//  </select>
```

## selectRange

Returns a select range field.

```php
use Zaphyr\Utils\Form;

Form::selectRange('year', 1989, 1991);
// <select name="year">
//      <option value="1989">1989</option>
//      <option value="1990">1990</option>
//      <option value="1991">1991</option>
//  </select>

Form::selectRange('year', 1989, 1991, 1990);
// <select name="year">
//      <option value="1989">1989</option>
//      <option value="1990" selected="selected">1990</option>
//      <option value="1991">1991</option>
//  </select>

Form::selectRange('year', 1989, 1991, '1990', ['class' => 'form-class']);
// <select class="form-class" name="year">
//      <option value="1989">1989</option>
//      <option value="1990" selected="selected">1990</option>
//      <option value="1991">1991</option>
//  </select>

Form::selectRange('year', 1989, 1991, null, [], ['1989' => ['data-foo' => 'foo', 'disabled']]);
// <select name="year">
//		<option value="1989" data-foo="foo" disabled>1989</option>
//		<option value="1990">1990</option>
//		<option value="1991">1991</option>
//	</select>
```

## datalist

Returns a datalist field.

```php
use Zaphyr\Utils\Form;

Form::datalist('genders', ['male', 'female']);
// <datalist id="genders">
//      <option value="male">male</option>
//      <option value="female">female</option>
//  </datalist>

Form::datalist('genders', ['m' => 'male', 'f' => 'female']);
// <datalist id="genders">
//      <option value="m">male</option>
//      <option value="f">female</option>
// </datalist>

Form::datalist('genders', [1 => 'male', 2 => 'female']);
// <datalist id="genders">
//      <option value="1">male</option>
//      <option value="2">female</option>
// </datalist>
```
