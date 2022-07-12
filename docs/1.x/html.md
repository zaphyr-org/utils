# HTML helper

## Table of contents

- [attributes](#attributes)
- [attributeElements](#attributeelements)

## attributes

Builds an HTML attribute string from an array.

```php
use Zaphyr\Utils\HTML;

$attributes = ['id' => 'foo', 'class' => ['bar', 'baz']];

HTML::attributes($attributes); // ' id="foo" class="bar baz"'
```

## attributeElements

Builds a single HTML attribute element.

```php
use Zaphyr\Utils\HTML;

HTML::attributeElement('id', 'foo'); // 'id="foo"'

HTML::attributeElement('class', ['bar', 'baz']); // 'class="bar baz"'
```
