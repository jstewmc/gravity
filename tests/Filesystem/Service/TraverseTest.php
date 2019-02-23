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

    public function testInvokeIfEmpty(): void
    {
        $root = new Root($this->root->url());

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([]);
        $actual   = $sut($root, 'foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfProjectHasFiles(): void
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
        $actual = $sut($root, 'foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfPackagesHaveFiles(): void
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
        $actual = $sut($root, 'foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfEnvironmentHasFiles(): void
    {
        $root = new Root($this->root->url());

        // create Composer's directory in the project's root
        $vendors = vfsStream::newDirectory(
            $this->directories['vendors']
        )->at($this->root);

        // create a vendor, package, gravity, and environments directory
        $vendor1  = vfsStream::newDirectory('vendor1')->at($vendors);
        $package1 = vfsStream::newDirectory('package1')->at($vendor1);
        $gravity1 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package1);
        $env1     = vfsStream::newDirectory('environments')->at($gravity1);
        $file1    = vfsStream::newFile('foo.php')->at($env1);

        // create a second vendor, package, and gravity directory
        $vendor2  = vfsStream::newDirectory('vendor2')->at($vendors);
        $package2 = vfsStream::newDirectory('package1')->at($vendor2);
        $gravity2 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package2);
        $env2     = vfsStream::newDirectory('environments')->at($gravity2);
        $file2    = vfsStream::newFile('foo.php')->at($env2);

        // create a second package in the second vendor directory
        $package3 = vfsStream::newDirectory('package2')->at($vendor2);
        $gravity3 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package3);
        $env3     = vfsStream::newDirectory('environments')->at($gravity3);
        $file3    = vfsStream::newFile('foo.php')->at($env3);

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = $sut($root, 'foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfEnvironmentHasDirectories(): void
    {
        $root = new Root($this->root->url());

        // create Composer's directory
        $vendors = vfsStream::newDirectory(
            $this->directories['vendors']
        )->at($this->root);

        // create a vendor, package, gravity, and environments directory
        $vendor1  = vfsStream::newDirectory('vendor1')->at($vendors);
        $package1 = vfsStream::newDirectory('package1')->at($vendor1);
        $gravity1 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package1);
        $env1     = vfsStream::newDirectory('environments')->at($gravity1);
        $foo1     = vfsStream::newDirectory('foo')->at($env1);
        $file1    = vfsStream::newFile('bar.php')->at($foo1);

        // create a second vendor, package, and gravity directory
        $vendor2  = vfsStream::newDirectory('vendor2')->at($vendors);
        $package2 = vfsStream::newDirectory('package1')->at($vendor2);
        $gravity2 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package2);
        $env2     = vfsStream::newDirectory('environments')->at($gravity2);
        $foo2     = vfsStream::newDirectory('foo')->at($env2);
        $file2    = vfsStream::newFile('baz.php')->at($foo2);

        // create a second package in the second vendor directory
        $package3 = vfsStream::newDirectory('package2')->at($vendor2);
        $gravity3 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package3);
        $env3     = vfsStream::newDirectory('environments')->at($gravity3);
        $foo3     = vfsStream::newDirectory('foo')->at($env3);
        $file3    = vfsStream::newFile('qux.php')->at($foo3);

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([
            new SplFileInfo($file1->url()),
            new SplFileInfo($file2->url()),
            new SplFileInfo($file3->url())
        ]);
        $actual = $sut($root, 'foo');

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeExcludesOtherEnvironmentFiles(): void
    {
        $root = new Root($this->root->url());

        $environment = 'foo';

        // create a project-level gravity directory
        $gravity = vfsStream::newDirectory(
            $this->directories['gravity']
        )->at($this->root);

        // create an environments directory
        $environments = vfsStream::newDirectory('environments')->at($gravity);

        // create a file with the environment name
        $filename = "{$environment}.php";
        $file1 = vfsStream::newFile($filename)->at($environments);

        // create a file without the environment name
        $filename = strrev($environment) . '.php';
        $file2 = vfsStream::newFile($filename)->at($environments);

        $sut = new Traverse($this->directories, $this->logger);

        $expected = new Traversed([
            new SplFileInfo($file2->url()),
        ]);
        $actual = $sut($root, $environment);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsFilesInOrder(): void
    {
        $root = new Root($this->root->url());

        $environment = 'foo';

        // create a project-level gravity directory
        $gravity = vfsStream::newDirectory(
            $this->directories['gravity']
        )->at($this->root);

        // create a global project file
        $file1 = vfsStream::newFile('foo.php')->at($gravity);

        // create a local project file
        $environments = vfsStream::newDirectory('environments')->at($gravity);
        $filename     = "{$environment}.php";
        $file2        = vfsStream::newFile($filename)->at($environments);

        // create Composer directory
        $vendors = vfsStream::newDirectory(
            $this->directories['vendors']
        )->at($this->root);

        // create a vendor, package, gravity, and environments directory
        $vendor1  = vfsStream::newDirectory('vendor1')->at($vendors);
        $package1 = vfsStream::newDirectory('package1')->at($vendor1);
        $gravity1 = vfsStream::newDirectory($this->directories['gravity'])
            ->at($package1);

        // create a global package file
        $file3 = vfsStream::newFile('foo.php')->at($gravity1);

        // create a local package file
        $environments1 = vfsStream::newDirectory('environments')->at($gravity1);
        $file4 = vfsStream::newFile($filename)->at($environments1);

        $sut = new Traverse($this->directories, $this->logger);

        // expect package global, project global, package local, project local
        $expected = new Traversed([
            new SplFileInfo($file3->url()),
            new SplFileInfo($file1->url()),
            new SplFileInfo($file4->url()),
            new SplFileInfo($file2->url())
        ]);
        $actual = $sut($root, $environment);

        $this->assertEquals($expected, $actual);

        return;
    }
}
