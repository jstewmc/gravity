<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\Filesystem\Data\Traversed;
use Jstewmc\Gravity\Root\Data\Root;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory};
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SplFileInfo;

class TraverseTest extends TestCase
{
    /**
     * @var  string[]  an array of directory names
     */
    private $directories = [
        'gravity' => '.gravity',
        'vendors' => 'vendor'
    ];

    /**
     * @var  vfsStreamDirectory  the "root" virtual file system directory
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

        $this->logger = $this->createMock(LoggerInterface::class);

        return;
    }

    public function testInvokeReturnsFilesystemIfEmpty(): void
    {
        $root = new Root($this->root->url());

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([]);
        $actual   = $sut($root);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsFilesystemIfProjectHasFiles(): void
    {
        $root = new Root($this->root->url());

        // create a project-level gravity directory
        $gravity = vfsStream::newDirectory(
            $this->directories['gravity']
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

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = $sut($root);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsFilesystemIfPackagesHaveFiles(): void
    {
        $root = new Root($this->root->url());

        // create Composer's directory
        $vendors = vfsStream::newDirectory(
            $this->directories['vendors']
        )->at($this->root);

        // create a vendor, package, and gravity directory
        $vendor1  = vfsStream::newDirectory('vendor1')->at($vendors);
        $package1 = vfsStream::newDirectory('package1')->at($vendor1);
        $gravity1 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package1);
        $file1    = vfsStream::newFile('foo.php')->at($gravity1);

        // create a second vendor, package, and gravity directory
        $vendor2  = vfsStream::newDirectory('vendor2')->at($vendors);
        $package2 = vfsStream::newDirectory('package1')->at($vendor2);
        $gravity2 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package2);
        $file2    = vfsStream::newFile('bar.php')->at($gravity2);

        // create a second package in the second vendor directory
        $package3 = vfsStream::newDirectory('package2')->at($vendor2);
        $gravity3 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package3);
        $file3    = vfsStream::newFile('baz.php')->at($gravity3);

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = $sut($root);

        $this->assertEquals($expected, $actual);

        return;
    }
}
