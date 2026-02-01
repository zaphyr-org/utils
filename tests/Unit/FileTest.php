<?php

declare(strict_types=1);

namespace Zaphyr\UtilsTests\Unit;

use __PHP_Incomplete_Class;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use stdClass;
use Zaphyr\Utils\Exceptions\FileNotFoundException;
use Zaphyr\Utils\File;

class FileTest extends TestCase
{
    /**
     * @var string
     */
    protected string $tempDir;

    public function setUp(): void
    {
        $this->tempDir = __DIR__ . '/temp';
        mkdir($this->tempDir);
    }

    public function tearDown(): void
    {
        File::deleteDirectory($this->tempDir);
    }

    protected function getFilePermissions(string $file): int
    {
        $filePerms = fileperms($file);
        $filePerms = substr(sprintf('%o', $filePerms), -3);

        return (int)base_convert($filePerms, 8, 10);
    }

    /**
     * ------------------------------------------
     * EXISTS
     * ------------------------------------------
     */

    public function testExists(): void
    {
        // file
        self::assertTrue(File::exists(__DIR__ . '/FileTest.php'));
        self::assertFalse(File::exists(__DIR__ . '/Invalid.php'));

        // dir
        self::assertTrue(File::exists(__DIR__));
        self::assertFalse(File::exists(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * IS FILE
     * ------------------------------------------
     */

    public function testIsFile(): void
    {
        self::assertTrue(File::isFile(__DIR__ . '/FileTest.php'));
        self::assertFalse(File::isFile(__DIR__ . '/Invalid.php'));
        self::assertFalse(File::isFile(__DIR__));
    }

    /**
     * ------------------------------------------
     * IS DIR
     * ------------------------------------------
     */

    public function testIsDirectory(): void
    {
        self::assertTrue(File::isDirectory(__DIR__));
        self::assertFalse(File::isDirectory('/invalid'));
        self::assertFalse(File::isDirectory(__DIR__ . 'FileTest.php'));
    }

    /**
     * ------------------------------------------
     * INFO
     * ------------------------------------------
     */

    public function testInfo(): void
    {
        // file
        self::assertEquals('php', File::info(__DIR__ . '/FileTest.php', PATHINFO_EXTENSION));
        self::assertNull(File::info(__DIR__ . '/Invalid.php', PATHINFO_EXTENSION));

        // dir
        self::assertEquals(dirname(__DIR__), File::info(__DIR__, PATHINFO_DIRNAME));
        self::assertNull(File::info(__DIR__ . '/invalid', PATHINFO_DIRNAME));
    }

    /**
     * ------------------------------------------
     * NAME
     * ------------------------------------------
     */

    public function testName(): void
    {
        // file
        self::assertEquals('FileTest', File::name(__DIR__ . '/FileTest.php'));
        self::assertNull(File::name(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals('Unit', File::name(__DIR__));
        self::assertNull(File::name(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * BASENAME
     * ------------------------------------------
     */

    public function testBasename(): void
    {
        // file
        self::assertEquals('FileTest.php', File::basename(__DIR__ . '/FileTest.php'));
        self::assertNull(File::basename(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals('Unit', File::basename(__DIR__));
        self::assertNull(File::basename(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * DIRNAME
     * ------------------------------------------
     */

    public function testDirname(): void
    {
        // file
        self::assertEquals(__DIR__, File::dirname(__DIR__ . '/FileTest.php'));
        self::assertNull(File::dirname(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals(dirname(__DIR__), File::dirname(__DIR__));
        self::assertNull(File::dirname(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * EXTENSION
     * ------------------------------------------
     */

    public function testExtension(): void
    {
        self::assertEquals('php', File::extension(__DIR__ . '/FileTest.php'));
        self::assertNull(File::extension(__DIR__ . '/Invalid.php'));
        self::assertNull(File::extension(__DIR__));
    }

    /**
     * ------------------------------------------
     * TYPE
     * ------------------------------------------
     */

    public function testType(): void
    {
        // file
        self::assertEquals('file', File::type(__DIR__ . '/FileTest.php'));
        self::assertNull(File::type(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals('dir', File::type(__DIR__));
        self::assertNull(File::type(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * MIME TYPE
     * ------------------------------------------
     */

    public function testMimeType(): void
    {
        // file
        self::assertEquals('text/x-php', File::mimeType(__DIR__ . '/FileTest.php'));
        self::assertNull(File::mimeType(__DIR__ . 'Invalid.php'));

        // dir
        self::assertEquals('directory', File::mimeType(__DIR__));
        self::assertNull(File::mimeType(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * SIZE
     * ------------------------------------------
     */

    public function testSize(): void
    {
        // file
        self::assertEquals(filesize(__DIR__ . '/FileTest.php'), File::size(__DIR__ . '/FileTest.php'));
        self::assertNull(File::size(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals(filesize(__DIR__), File::size(__DIR__));
        self::assertNull(File::size(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * HASH
     * ------------------------------------------
     */

    public function testHash(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'foo');

        self::assertEquals('acbd18db4cc2f85cedef654fccc4a4d8', File::hash($file));
        self::assertNull(File::hash(__DIR__));
    }

    /**
     * ------------------------------------------
     * CHMOD
     * ------------------------------------------
     */

    public function testSetChmod(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'foo');
        File::chmod($file, 0755);

        $permission = substr(sprintf('%o', fileperms($file)), -4);
        $expectedPermissions = DIRECTORY_SEPARATOR === '\\' ? '0666' : '0755';

        self::assertEquals($expectedPermissions, $permission);
    }

    public function testGetChmod(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'foo');
        File::chmod($file, 0755);

        $permission = File::chmod($file);
        $expectedPermissions = DIRECTORY_SEPARATOR === '\\' ? '0666' : '0755';

        self::assertEquals($expectedPermissions, $permission);
    }

    /**
     * ------------------------------------------
     * LAST MODIFIED
     * ------------------------------------------
     */

    public function testLastModified(): void
    {
        // file
        self::assertEquals(filemtime(__DIR__ . '/FileTest.php'), File::lastModified(__DIR__ . '/FileTest.php'));
        self::assertNull(File::lastModified(__DIR__ . '/Invalid.php'));

        // dir
        self::assertEquals(filemtime(__DIR__), File::lastModified(__DIR__));
        self::assertNull(File::lastModified(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * IS READABLE
     * ------------------------------------------
     */

    public function testIsReadable(): void
    {
        // file
        self::assertTrue(File::isReadable(__DIR__ . '/FileTest.php'));
        self::assertFalse(File::isReadable(__DIR__ . '/Invalid.php'));

        // dir
        self::assertTrue(File::isReadable(__DIR__));
        self::assertFalse(File::isReadable(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * IS WRITABLE
     * ------------------------------------------
     */

    public function testIsWritable(): void
    {
        // file
        self::assertTrue(File::isWritable(__DIR__ . '/FileTest.php'));
        self::assertFalse(File::isWritable(__DIR__ . '/Invalid.php'));

        // dir
        self::assertTrue(File::isWritable(__DIR__));
        self::assertFalse(File::isWritable(__DIR__ . '/invalid'));
    }

    /**
     * ------------------------------------------
     * GLOB
     * ------------------------------------------
     */

    public function testGlob(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'foo');

        self::assertContains($file, File::glob($this->tempDir . '/*.*'));
        self::assertNull(File::glob($this->tempDir . '/*.php'));
    }

    /**
     * ------------------------------------------
     * FILES
     * ------------------------------------------
     */

    public function testFiles(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp');
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');
        file_put_contents($tempDir . '/.hidden', 'hidden');
        mkdir($tempDir . '/subdir');
        file_put_contents($tempDir . '/subdir/baz.txt', 'baz');

        self::assertCount(2, $files = File::files($tempDir));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testFilesIncludingHiddenFiles(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp');
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');
        file_put_contents($tempDir . '/.hidden', 'hidden');
        mkdir($tempDir . '/subdir');
        file_put_contents($tempDir . '/subdir/baz.txt', 'baz');

        self::assertCount(3, $files = File::files($tempDir, true));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testFilesReturnsNullOnInvalidDirectory(): void
    {
        self::assertNull(File::files('nope'));
    }

    /**
     * ------------------------------------------
     * ALL FILES
     * ------------------------------------------
     */

    public function testAllFiles(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp');
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');
        file_put_contents($tempDir . '/.hidden', 'hidden');
        mkdir($tempDir . '/subdir');
        file_put_contents($tempDir . '/subdir/baz.txt', 'baz');
        file_put_contents($tempDir . '/subdir/.subhidden', 'subhidden');
        mkdir($tempDir . '/.hiddendir');
        file_put_contents($tempDir . '/.hiddendir/qux.txt', 'qux');

        self::assertCount(3, $files = File::allFiles($tempDir));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testAllFilesIncludingHiddenFiles(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp');
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');
        file_put_contents($tempDir . '/.hidden', 'hidden');
        mkdir($tempDir . '/subdir');
        file_put_contents($tempDir . '/subdir/baz.txt', 'baz');
        file_put_contents($tempDir . '/subdir/.subhidden', 'subhidden');
        mkdir($tempDir . '/.hiddendir');
        file_put_contents($tempDir . '/.hiddendir/qux.txt', 'qux');

        self::assertCount(6, $files = File::allFiles($tempDir, true));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testAllFilesReturnsNullOnInvalidDirectory(): void
    {
        self::assertNull(File::allFiles('nope'));
    }

    /**
     * ------------------------------------------
     * DIRECTORIES
     * ------------------------------------------
     */

    public function testDirectories(): void
    {
        mkdir($foo = $this->tempDir . '/foo');
        file_put_contents($foo . '/foo.txt', 'foo');
        mkdir($this->tempDir . '/bar');
        mkdir($this->tempDir . '/.hidden');

        self::assertCount(2, $files = File::directories($this->tempDir));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testDirectoriesIncludingHiddenDirectories(): void
    {
        mkdir($foo = $this->tempDir . '/foo');
        file_put_contents($foo . '/foo.txt', 'foo');
        mkdir($this->tempDir . '/bar');
        mkdir($this->tempDir . '/.hidden');

        self::assertCount(3, $files = File::directories($this->tempDir, true));
        self::assertContainsOnlyInstancesOf(SplFileInfo::class, $files);
    }

    public function testDirectoriesReturnsNullOnInvalidDirectory(): void
    {
        self::assertNull(File::directories('nope'));
    }

    /**
     * ------------------------------------------
     * GET REQUIRE
     * ------------------------------------------
     */

    public function testGetRequire(): void
    {
        file_put_contents($file = $this->tempDir . '/file.php', '<?php return "foo";');

        self::assertEquals('foo', File::getRequire($file));
    }

    public function testGetRequireThrowsExceptionOnNonExistingFile(): void
    {
        $this->expectException(FileNotFoundException::class);

        File::getRequire(__DIR__ . '/Invalid.php');
    }

    /**
     * ------------------------------------------
     * GET REQUIRE ONCE
     * ------------------------------------------
     */

    public function testGetRequireOnce(): void
    {
        mkdir($this->tempDir . '/dir');
        file_put_contents($file = $this->tempDir . '/dir/File.php', '<?php function foo(){};');

        File::getRequireOnce($file);

        file_put_contents($file = $this->tempDir . '/dir/File.php', '<?php function bar(){};');

        File::getRequireOnce($file);

        self::assertTrue(function_exists('foo'));
        self::assertFalse(function_exists('bar'));
    }

    public function testGetRequireOnceThrowsExceptionOnNonExistingFile(): void
    {
        $this->expectException(FileNotFoundException::class);

        File::getRequireOnce(__DIR__ . '/Invalid.php');
    }

    /**
     * ------------------------------------------
     * READ
     * ------------------------------------------
     */

    public function testRead(): void
    {
        file_put_contents($file = $this->tempDir . '/file.txt', 'foo');

        self::assertEquals('foo', File::read($file));
    }

    public function testReadWithLock(): void
    {
        file_put_contents($file = $this->tempDir . '/file.txt', 'foo');

        self::assertEquals('foo', File::read($file, true));
    }

    public function testReadThrowsExceptionOnNonExistingFile(): void
    {
        $this->expectException(FileNotFoundException::class);

        File::read(__DIR__ . '/invalid.txt');
    }

    /**
     * ------------------------------------------
     * PUT
     * ------------------------------------------
     */

    public function testPut(): void
    {
        self::assertIsInt(File::put($file = $this->tempDir . '/foo.txt', $contents = 'foo'));
        self::assertStringEqualsFile($file, $contents);
    }

    /**
     * ------------------------------------------
     * REPLACE
     * ------------------------------------------
     */

    public function testReplace(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Windows does not work on Windows');
        }

        mkdir($symlinkDir = $this->tempDir . '/symlink_dir');
        symlink($file = $this->tempDir . '/file.txt', $symlinkFile = $this->tempDir . '/symlink.txt');
        chmod($symlinkDir, 0555);

        $originalUmask = umask($umask = 0131);

        // replacing non-existent file
        File::replace($file, 'Foo');

        self::assertStringEqualsFile($file, 'Foo');
        self::assertEquals($umask, 0777 - $this->getFilePermissions($file));

        // Test replacing existing file
        File::replace($file, 'Bar');

        self::assertStringEqualsFile($file, 'Bar');
        self::assertEquals($umask, 0777 - $this->getFilePermissions($file));

        // Test replacing symlinked file
        File::replace($symlinkFile, 'Baz');

        self::assertStringEqualsFile($file, 'Baz');
        self::assertEquals($umask, 0777 - $this->getFilePermissions($file));

        umask($originalUmask);
        chmod($symlinkDir, 0777 - $originalUmask);
    }

    /**
     * ------------------------------------------
     * PREPEND
     * ------------------------------------------
     */

    public function testPrependExistingFile(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'bar');
        File::prepend($file, 'foo');

        self::assertStringEqualsFile($file, 'foobar');
    }

    public function testPrependNewFile(): void
    {
        File::prepend($file = $this->tempDir . '/foo.txt', $contents = 'foo');

        self::assertStringEqualsFile($file, $contents);
    }

    /**
     * ------------------------------------------
     * APPEND
     * ------------------------------------------
     */

    public function testAppend(): void
    {
        file_put_contents($file = $this->tempDir . '/foo.txt', 'foo');

        self::assertIsInt(File::append($file, 'bar'));
        self::assertStringEqualsFile($file, 'foobar');
    }

    /**
     * ------------------------------------------
     * DELETE
     * ------------------------------------------
     */

    public function testDelete(): void
    {
        file_put_contents($file1 = $this->tempDir . '/foo.txt', 'foo');
        file_put_contents($file2 = $this->tempDir . '/bar.txt', 'bar');
        file_put_contents($file3 = $this->tempDir . '/baz.txt', 'baz');

        self::assertTrue(File::delete($file1));
        self::assertFileDoesNotExist($file1);
        self::assertTrue(File::delete([$file2, $file3]));
        self::assertFileDoesNotExist($file2);
        self::assertFileDoesNotExist($file3);
    }

    /**
     * ------------------------------------------
     * MOVE
     * ------------------------------------------
     */

    public function testMove(): void
    {
        file_put_contents($file1 = $this->tempDir . '/foo.txt', 'foo');

        self::assertTrue(File::move($file1, $file2 = $this->tempDir . '/bar.txt'));
        self::assertFileDoesNotExist($file1);
        self::assertFileExists($file2);
    }

    public function testMoveReturnsFalseOnNonExistingFile(): void
    {
        self::assertFalse(File::move($this->tempDir . '/foo.txt', $this->tempDir . '/bar.txt'));
    }

    /**
     * ------------------------------------------
     * COPY
     * ------------------------------------------
     */

    public function testCopy(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp');
        file_put_contents($file1 = $tempDir . '/foo.txt', $contents = 'foo');
        File::copy($file1, $file2 = $tempDir . '/bar.txt');

        self::assertFileExists($file2);
        self::assertEquals($contents, file_get_contents($file2));
    }

    public function testCopyReturnsFalseOnNonExistingFile(): void
    {
        self::assertFalse(File::copy($this->tempDir . '/foo.txt', $this->tempDir . '/bar.txt'));
    }

    /**
     * ------------------------------------------
     * SERIALIZE
     * ------------------------------------------
     */

    public function testSerialize(): void
    {
        self::assertIsInt(File::serialize($file = $this->tempDir . '/foo', $data = ['foo' => 'bar']));
        self::assertEquals($data, File::unserialize($file));
    }

    public function testUnserializeWithOptions(): void
    {
        $testObject = new stdClass();
        $testObject->name = 'Test';

        File::serialize($file = $this->tempDir . '/foo', $testObject);

        $result = File::unserialize($file, options: ['allowed_classes' => false]);

        self::assertInstanceOf(__PHP_Incomplete_Class::class, $result);
    }

    /**
     * ------------------------------------------
     * CREATE DIRECTORY
     * ------------------------------------------
     */

    public function testCreateDirectory(): void
    {
        self::assertTrue(File::createDirectory($tempDir = $this->tempDir . '/foo'));
        self::assertFileExists($tempDir);
    }

    public function testCreateDirectoryForce(): void
    {
        self::assertTrue(File::createDirectory($tempDir = $this->tempDir . '/foo', 0777, false, true));
        self::assertFileExists($tempDir);
    }

    /**
     * ------------------------------------------
     * DELETE DIRECTORY
     * ------------------------------------------
     */

    public function testDeleteDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/foo');
        file_put_contents($file = $tempDir . '/file.txt', 'foo');

        File::deleteDirectory($tempDir);

        self::assertDirectoryDoesNotExist($tempDir);
        self::assertFileDoesNotExist($file);
    }

    public function testDeleteDirectoryReturnsFalseWhenNoDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/foo');
        file_put_contents($file = $tempDir . '/file.txt', 'foo');

        self::assertFalse(File::deleteDirectory($file));
    }

    /**
     * ------------------------------------------
     * CLEAN DIRECTORY
     * ------------------------------------------
     */

    public function testCleanDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/dir');
        file_put_contents($file = $tempDir . '/foo.txt', 'Foo');

        File::cleanDirectory($tempDir);

        self::assertDirectoryExists($tempDir);
        self::assertFileDoesNotExist($file);
    }

    /**
     * ------------------------------------------
     * MOVE DIRECTORY
     * ------------------------------------------
     */

    public function testMoveEntireDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp', 0777, true);
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');

        mkdir($tempDirNested = $tempDir . '/nested', 0777, true);
        file_put_contents($tempDirNested . '/baz.txt', 'baz');

        File::moveDirectory($tempDir, $tempDir2 = $this->tempDir . '/tmp2');

        self::assertDirectoryExists($tempDir2);
        self::assertFileExists($tempDir2 . '/foo.txt');
        self::assertFileExists($tempDir2 . '/bar.txt');
        self::assertDirectoryExists($tempDir2 . '/nested');
        self::assertFileExists($tempDir2 . '/nested/baz.txt');
        self::assertDirectoryDoesNotExist($tempDir);
    }

    public function testMoveEntireDirectoryAndOverwrite(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp', 0777, true);
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');

        mkdir($tempDirNested = $tempDir . '/nested', 0777, true);
        file_put_contents($tempDirNested . '/baz.txt', 'baz');

        mkdir($tempDir2 = $this->tempDir . '/tmp2', 0777, true);
        file_put_contents($tempDir2 . '/foo2.txt', 'foo2');
        file_put_contents($tempDir2 . '/bar2.txt', 'foo2');

        File::moveDirectory($tempDir, $tempDir2, true);

        self::assertDirectoryExists($tempDir2);
        self::assertFileExists($tempDir2 . '/foo.txt');
        self::assertFileExists($tempDir2 . '/bar.txt');
        self::assertDirectoryExists($tempDir2 . '/nested');
        self::assertFileExists($tempDir2 . '/nested/baz.txt');
        self::assertFileDoesNotExist($tempDir2 . '/foo2.txt');
        self::assertFileDoesNotExist($tempDir2 . '/bar2.txt');
        self::assertDirectoryDoesNotExist($tempDir);
    }

    public function testMoveDirectoryReturnsFalseWhileOverwritingAndUnableToDeleteDestinationDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp', 0777, true);
        file_put_contents($tempDir . '/foo.txt', 'foo');

        self::assertFalse(File::moveDirectory($tempDir, '/none/existing/dir', true));
    }

    /**
     * ------------------------------------------
     * COPY DIRECTORY
     * ------------------------------------------
     */

    public function testCopyDirectory(): void
    {
        mkdir($tempDir = $this->tempDir . '/tmp', 0777, true);
        file_put_contents($tempDir . '/foo.txt', 'foo');
        file_put_contents($tempDir . '/bar.txt', 'bar');
        mkdir($tempDir . '/nested', 0777, true);
        file_put_contents($tempDir . '/nested/baz.txt', 'baz');

        File::copyDirectory($tempDir, $tempDir2 = $this->tempDir . '/tmp2');

        self::assertDirectoryExists($tempDir2);
        self::assertFileExists($tempDir2 . '/foo.txt');
        self::assertFileExists($tempDir2 . '/bar.txt');
        self::assertDirectoryExists($tempDir2 . '/nested');
        self::assertFileExists($tempDir2 . '/nested/baz.txt');
    }

    public function testCopyDirectoryReturnsNullWhenSourceIsNotADirectory(): void
    {
        self::assertFalse(File::copyDirectory('/nope', $this->tempDir));
    }
}
