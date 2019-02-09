<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\{File, Ns, Script};
use PHPUnit\Framework\TestCase;

/**
 * @group file
 */
class CloseTest extends TestCase
{
    public function testInvoke(): void
    {
        $pathname  = '/path/to/foo.php';
        $namespace = new Ns\Data\Opened();
        $script    = new Script\Data\Opened();
        $opened    = new File\Data\Opened($pathname, $namespace, $script);

        $namespace = $this->createMock(Ns\Data\Closed::class);
        $closeNamespace = $this->createMock(Ns\Service\Close::class);
        $closeNamespace->method('__invoke')->willReturn($namespace);

        $script = $this->createMock(Script\Data\Closed::class);
        $closeScript = $this->createMock(Script\Service\Close::class);
        $closeScript->method('__invoke')->willReturn($script);

        $sut = new Close($closeNamespace, $closeScript);

        $expected = new File\Data\Closed($pathname, $namespace, $script);
        $actual   = $sut($opened);

        $this->assertEquals($expected, $actual);
    }
}
