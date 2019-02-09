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
class ParseTest extends TestCase
{
    public function testInvoke(): void
    {
        $pathname  = '/path/to/foo.php';
        $namespace = new Ns\Data\Closed();
        $script    = new Script\Data\Closed();
        $closed    = new File\Data\Closed($pathname, $namespace, $script);

        $namespace = $this->createMock(Ns\Data\Parsed::class);
        $parseNamespace = $this->createMock(Ns\Service\Parse::class);
        $parseNamespace->method('__invoke')->willReturn($namespace);

        $script = $this->createMock(Script\Data\Parsed::class);
        $parseScript = $this->createMock(Script\Service\Parse::class);
        $parseScript->method('__invoke')->willReturn($script);

        $sut = new Parse($parseNamespace, $parseScript);

        $expected = new File\Data\Parsed($pathname, $namespace, $script);
        $actual   = $sut($closed);

        $this->assertEquals($expected, $actual);
    }
}
