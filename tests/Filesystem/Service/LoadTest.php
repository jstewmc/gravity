<?php
/**
 * The file for the load-filesystem service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use Jstewmc\Gravity\Manager;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;
use SplFileInfo;

/**
 * Tests for the load-filesystem service
 *
 * @since  0.1.0
 */
class LoadTest extends TestCase
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


    public function testInvoke(): void
    {
        // create a valid gravity file (location doesn't matter)
        $file = vfsStream::newFile('foo.php')
			->withContent('<?php
                $g->alias("foo\bar\baz", "foo\bar\qux");
                $g->set("foo\bar\qux");
                $g->deprecate("foo\bar\baz");
            ')
			->at($this->root);

        // set up a filesystem to return the file
        $file = new SplFileInfo($file->url());

        $filesystem = $this->createMock(Filesystem::class);
        $filesystem->method('getFiles')->willReturn([$file]);

        // set up the manager's expectations (skip the original constructor to
        // avoid bootstrapping, loading, etc)
        $manager = $this->getMockBuilder(Manager::class)
            ->disableOriginalConstructor()
            ->setMethods(['alias', 'deprecate', 'set'])
            ->getMock();

        $manager
            ->expects($this->once())
            ->method('alias')
            ->with('foo\bar\baz', 'foo\bar\qux');

        $manager
            ->expects($this->once())
            ->method('deprecate')
            ->with('foo\bar\baz');

        $manager
            ->expects($this->once())
            ->method('set')
            ->with('foo\bar\qux');

        (new Load())($filesystem, $manager);

        return;
    }
}
