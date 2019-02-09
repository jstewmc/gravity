<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\Opened;
use Jstewmc\Gravity\Ns\Data\Opened as Ns;
use Jstewmc\Gravity\Script\Data\Opened as Script;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};
use PHPUnit\Framework\TestCase;

/**
 * @group  file
 */
class ReadTest extends TestCase
{
    protected $root;

    protected $file;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('test');

        $this->file = vfsStream::newFile('foo.php')
            ->at($this->root)
            ->withContent('<?php throw new Exception();');

        return;
    }

    public function testInvoke(): void
    {
        $this->expectException(\Exception::class);

        $file = new Opened($this->file->url(), new Ns(), new Script());

        (new Read())($file);
    }
}
