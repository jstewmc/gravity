<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Closed as Ns;
use Jstewmc\Gravity\Script\Data\Closed as Script;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;

class ClosedTest extends TestCase
{
    /**
     * @var  vfsStreamDirectory  the "root" virtual file system directory
     */
    protected $root;

    /**
     * @var  vfsStreamFile  an "actual" file to test
     */
    protected $file;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('test');

        $this->file = vfsStream::newFile('foo.php')->at($this->root);

        return;
    }

    public function testGetNamespace(): void
    {
        $namespace = $this->createMock(Ns::class);
        $script    = $this->createMock(Script::class);

        $file = new Closed($this->file->url(), $namespace, $script);

        $this->assertSame($namespace, $file->getNamespace());
    }

    public function testGetScript(): void
    {
        $namespace = $this->createMock(Ns::class);
        $script    = $this->createMock(Script::class);

        $file = new Closed($this->file->url(), $namespace, $script);

        $this->assertSame($script, $file->getScript());
    }
}
