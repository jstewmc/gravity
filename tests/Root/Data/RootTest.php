<?php
/**
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Data;

use Jstewmc\Gravity\Root\Exception\{NotDirectory, NotReadable};
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;

class FoundTest extends TestCase
{
    /**
     * @var  vfsStreamDirectory  the "root" virtual file system directory
     */
    protected $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('test');

        return;
    }

    public function testIfNotReadeable()
    {
        $this->expectException(NotReadable::class);

        $directory = vfsStream::newDirectory('bar', 000)->at($this->root);

        new Root($directory->url());
    }

    public function testIfNotDirectory()
    {
        $this->expectException(NotDirectory::class);

        $file = vfsStream::newFile('foo.php')->at($this->root);

        new Root($file->url());
    }
}
