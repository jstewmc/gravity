<?php
/**
 * The file for the read-filesystem service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * Tests for the read-filesystem service
 *
 * @since  0.1.0
 */
class ReadTest extends TestCase
{
    /**
     * @var    vfsStreamDirectory  the "root" virtual file system directory
     * @since  0.1.0
     */
    private $root;

    /**
     * Called before each test
     *
     * @return  void
     */
    public function setUp(): void
    {
        $this->root = vfsStream::setup('test');

        return;
    }

    public function testInvokeReturnsFilesystemIfEmpty(): void
    {
        $expected = new Filesystem([]);
        $actual   = (new Read())($this->root->url());

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsFilesystemIfProjectHasFiles(): void
    {
        // create a project-level gravity directory
        $gravity = vfsStream::newDirectory(
            Filesystem::DIRECTORY_NAME_GRAVITY
        )->at($this->root);

        // create a file outside a sub-directory
        $file1 = vfsStream::newFile('foo.php')->at($gravity);

        // create a file inside a sub-directory
        $subDirectory1 = vfsStream::newDirectory('bar')->at($gravity);
        $file2 = vfsStream::newFile('bar.php')->at($subDirectory1);

        // create a file inside several sub-directories
        $subDirectory2 = vfsStream::newDirectory('baz')->at($gravity);
        $subDirectory3 = vfsStream::newDirectory('qux')->at($subDirectory2);
        $file3 = vfsStream::newFile('qux.php')->at($subDirectory3);

        $expected = new Filesystem([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = (new Read())($this->root->url());

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsFilesystemIfPackagesHaveFiles(): void
    {
        // create the Composer directory
        $vendors = vfsStream::newDirectory(
            Filesystem::DIRECTORY_NAME_VENDORS
        )->at($this->root);

        // create a vendor, package, and gravity directory
        $vendor1  = vfsStream::newDirectory('vendor1')->at($vendors);
        $package1 = vfsStream::newDirectory('package1')->at($vendor1);
        $gravity1 = vfsStream::newDirectory(Filesystem::DIRECTORY_NAME_GRAVITY)
            ->at($package1);
        $file1    = vfsStream::newFile('foo.php')->at($gravity1);

        // create a second vendor, package, and gravity directory
        $vendor2  = vfsStream::newDirectory('vendor2')->at($vendors);
        $package2 = vfsStream::newDirectory('package1')->at($vendor2);
        $gravity2 = vfsStream::newDirectory(Filesystem::DIRECTORY_NAME_GRAVITY)
            ->at($package2);
        $file2    = vfsStream::newFile('bar.php')->at($gravity2);

        // create a second package in the second vendor directory
        $package3 = vfsStream::newDirectory('package2')->at($vendor2);
        $gravity3 = vfsStream::newDirectory(Filesystem::DIRECTORY_NAME_GRAVITY)
            ->at($package3);
        $file3    = vfsStream::newFile('baz.php')->at($gravity3);

        $expected = new Filesystem([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = (new Read())($this->root->url());

        $this->assertEquals($expected, $actual);

        return;
    }
}
