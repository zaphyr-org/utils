# File helper

## Table of contents

- [exists](#exists)
- [isFile](#isfile)
- [isDirectory](#isdirectory)
- [info](#info)
- [name](#name)
- [basename](#basename)
- [dirname](#dirname)
- [extension](#extension)
- [type](#type)
- [mimeType](#mimeType)
- [size](#size)
- [hash](#hash)
- [chmod](#chmod)
- [lastModified](#lastmodified)
- [isReadable](#isreadable)
- [isWritable](#iswritable)
- [glob](#glob)
- [files](#files)
- [allFiles](#allfiles)
- [directories](#directories)
- [getRequire](#getrequire)
- [getRequireOne](#getrequireonce)
- [read](#read)
- [put](#put)
- [replace](#replace)
- [prepend](#prepend)
- [append](#append)
- [delete](#delete)
- [move](#move)
- [copy](#copy)
- [createDirectory](#createdirectory)
- [deleteDirectory](#deletedirectory)
- [cleanDirectory](#cleandirectory)
- [moveDirectory](#movedirectory)
- [copyDirectory](#copydirectory)

## exists

Determines whether a file or directory exists.

```php
use Zaphyr\Utils\File;

File::exists(__FILE__); // true
File::exists(__DIR__); // true
```

## isFile

Determines whether a file exists.

```php
use Zaphyr\Utils\File;

File::isFile(__FILE__); // true
File::isFile(__DIR__); // false
```

## isDirectory

Determines whether a directory exists.

```php
use Zaphyr\Utils\File;

File::isDir(__DIR__); // true
File::isDir(__FILE__); // false
```

## info

Returns a path information of a given file or directory.

```php
use Zaphyr\Utils\File;

File::info(__FILE__, PATHINFO_EXTENSION);
File::info(__DIR__, PATHINFO_DIRNAME);
```

## name

Returns the name of a file or directory path.

```php
use Zaphyr\Utils\File;

File::name(__FILE__);
File::name(__DIR__);
```

## basename

Returns the basename of a file or directory path.

```php
use Zaphyr\Utils\File;

File::basename(__FILE__);
File::basename(__DIR__);
```

## dirname

Returns the directory name of a file or directory.

```php
use Zaphyr\Utils\File;

File::dirname(__FILE__);
File::dirname(__DIR__);
```

## extension

Returns the file extension of a given file.

```php
use Zaphyr\Utils\File;

File::extension(__FILE__);
File::extension(__DIR__); // null
```

## type

Returns the type of file or directory.

```php
use Zaphyr\Utils\File;

File::type(__FILE__); // 'file'
File::type(__DIR__); // 'dir'
```

## mimeType

Returns the mime type of file or directory.

```php
use Zaphyr\Utils\File;

File::mimeType(__FILE__); // 'text/x-php'
File::mimeType(__DIR__); // 'directory'
```

## size

Returns the size of a file or directory.

```php
use Zaphyr\Utils\File;

File::type(__FILE__);
File::type(__DIR__);
```

## hash

Calculates the md5 hash of a given file.

```php
use Zaphyr\Utils\File;

File::hash(__FILE__);
File::hash(__DIR__); // null
```

## chmod

Changes the file mode.

```php
use Zaphyr\Utils\File;

// set chmod
File::chmod(__DIR__, '0775'); // bool

// get chmod
File::chmod(__DIR__); // '0775'
```

## lastModified

Returns the file modification time.

```php
use Zaphyr\Utils\File;

File::lastModified(__FILE__);
File::lastModified(__DIR__);
```

## isReadable

Determines whether a file or directory is readable.

```php
use Zaphyr\Utils\File;

File::isReadable(__FILE__); // true
File::isReadable(__DIR__); // true
```

## isWritable

Determines whether a file or directory is writable.

```php
use Zaphyr\Utils\File;

File::isWritable(__FILE__); // true
File::isWritable(__DIR__); // true
```

## glob

Finds all pathnames of a matching pattern.

```php
use Zaphyr\Utils\File;

File::glob(__DIR__ . '/*.*'); // [...]
```

## files

Returns all files in a given directory.

```php
use Zaphyr\Utils\File;

File::files(__DIR__); // SplFileInfo[]

// with hidden files
Files::files(__DIR__, true); // SplFileInfo[]

File::files('non-existing-dir'); // null
```

## allFiles

Returns all files in a given directory including all files in subdirectories.

```php
use Zaphyr\Utils\File;

File::allFiles(__DIR__); // SplFileInfo[]

// with hidden files
File::allFiles(__DIR__, true); // SplFileInfo[]

File::allFiles('non-existing-dir'); // null
```

## directories

Returns all directories inside a given directory.

```php
use Zaphyr\Utils\File;

File::directories(__DIR__); // SplFileInfo[]

// with hidden directories
File::directories(__DIR__, true); // SplFileInfo[]

File::directories('non-existing-dir'); // null
```

## getRequire

Requires a file.

```php
use Zaphyr\Utils\File;
use Zaphyr\Utils\Exceptions\FileNotFoundException;

try {
    File::getRequire(__FILE__);
} catch (FileNotFoundException $exception) {
    //
}
```

## getRequireOnce

Requires a file once.

```php
use Zaphyr\Utils\File;
use Zaphyr\Utils\Exceptions\FileNotFoundException;

try {
    File::getRequireOnce(__FILE__);
} catch (FileNotFoundException $exception) {
    //
}
```

## read

Reads the contents of a file.

```php
use Zaphyr\Utils\File;
use Zaphyr\Utils\Exceptions\FileNotFoundException;

try {
    File::read(__FILE__);
} catch (FileNotFoundException $exception) {
    //
}
```

## put

Puts content inside a file.

```php
use Zaphyr\Utils\File;

File::put(__FILE__, 'contents');
```

## replace

Replaces content inside a given file. If the file does not exist it will be created.

```php
use Zaphyr\Utils\File;

File::replace(__FILE__, 'contents');
```

## prepend

Prepends content to a given file. If the file does not exist it will be created.

```php
use Zaphyr\Utils\File;

File::prepend(__FILE__, 'contents');
```

## append

Appends content to a given file. If the file does not exist it will be created.

```php
use Zaphyr\Utils\File;

File::append(__FILE__, 'contents');
```

## delete

Deletes a given file.

```php
use Zaphyr\Utils\File;

File::delete('file'); // true
File::delete(['file1', 'file2']); // true
```

## move

Moves a file to a given directory.

```php
use Zaphyr\Utils\File;

$file = 'file';
$target = 'target';

File::move($file, $target); // true
```

## copy

Copies a file to a given directory.

```php
use Zaphyr\Utils\File;

$file = 'file';
$target = 'target';

File::copy($file, $target); // true
```

## createDirectory

Creates a new directory.

```php
use Zaphyr\Utils\File;

$directory = 'dirname';
$mode = 0755;
$recursive = false;
$force = false;

File::createDirectory($directory, $mode, $recursive, $force);
```

## deleteDirectory

Deletes an existing directory.

```php
use Zaphyr\Utils\File;

$directory = 'directory'
$preserve = false;

File::deleteDirectory($directory, $preserve); // true
File::deleteDirectory('none-existing-directory'); // false
```

## cleanDirectory

Removes all files and directories inside a given directory.

```php
use Zaphyr\Utils\File;

File::cleanDirectory('directory'); // true
File::cleanDirectory('none-existing-directory'); // false
```

## moveDirectory

Moves a directory to a given path.

```php
use Zaphyr\Utils\File;

$from = 'fromDir';
$to = 'toDir';

File::moveDirectory($from, $to);
```

## copyDirectory

Copies a directory to a given path.

```php
use Zaphyr\Utils\File;

$directory = 'fromDir';
$destination = 'toDir';
$options = \FilesystemIterator::SKIP_DOTS;

File::copyDirectory($directory, $destination, $options);
```
