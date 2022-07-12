# ClassFinder helper

## Table of contents

- [getClassesFromDirectory](#getclassesfromdirectory)
- [getClassNameFromFile](#getclassnamefromfile)
- [getNamespaceFromFile](#getnamespacefromfile)

## getClassesFromDirectory

Returns an array with all classes of a given directory.

```php
use Zaphyr\Utils\ClassFinder;

ClassFinder::getClassesFromDirectory('src'); // [...]
```

## getClassNameFromFile

Returns the class name of a given file.

```php
use Zaphyr\Utils\ClassFinder;

ClassFinder::getClassNameFromFile('src/Arr.php'); // 'Arr'
```

## getNamespaceFromFile

Returns the namespace from a given file.

```php
use Zaphyr\Utils\ClassFinder;

ClassFinder::getNamespaceFromFile('src/Arr.php'); // 'Zaphyr\Utils'
ClassFinder::getNamespaceFromFile('noClassFile.php'); // null
```
