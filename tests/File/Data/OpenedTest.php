<?php
/**
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Opened as Ns;
use Jstewmc\Gravity\Script\Data\Opened as Script;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;

class OpenedTest extends TestCase
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

    public function testAlias(): void
    {
        $file = $this->getFile();

        $this->assertSame($file, $file->alias('foo', 'bar'));
    }

    public function testDeprecate(): void
    {
        $file = $this->getFile();

        $this->assertSame($file, $file->deprecate('foo', 'bar'));
    }

    public function testGetNamespace(): void
    {
        $file = $this->getFile();

        $this->assertInstanceOf(Ns::class, $file->getNamespace());
    }

    public function testGetScript(): void
    {
        $file = $this->getFile();

        $this->assertInstanceOf(Script::class, $file->getScript());
    }

    public function testNamespace(): void
    {
        $file = $this->getFile();

        $this->assertSame($file, $file->namespace('foo'));
    }

    public function testSet(): void
    {
        $file = $this->getFile();

        $this->assertSame($file, $file->set('foo', 'bar'));
    }

    public function testUse(): void
    {
        $file = $this->getFile();

        $this->assertSame($file, $file->use('foo', 'bar'));
    }

    private function getFile(): Opened
    {
        return new Opened($this->file->url(), new Ns(), new Script());
    }
}
