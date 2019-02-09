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
class RunTest extends TestCase
{
    public function testInvoke(): void
    {
        $pathname  = '/path/to/foo.php';
        $namespace = new Ns\Data\Parsed();
        $script    = new Script\Data\Parsed();
        $parsed    = new File\Data\Parsed($pathname, $namespace, $script);

        $resolved = $this->createMock(Script\Data\Resolved::class);
        $resolve  = $this->createMock(Script\Service\Resolve::class);
        $resolve->method('__invoke')->willReturn($resolved);

        $interpreted = $this->createMock(Script\Data\Interpreted::class);
        $interpret   = $this->createMock(Script\Service\Interpret::class);
        $interpret->method('__invoke')->willReturn($interpreted);

        $sut = new Run($resolve, $interpret);

        $expected = new File\Data\Ran($pathname, $namespace, $interpreted);
        $actual   = $sut($parsed);

        $this->assertEquals($expected, $actual);
    }
}
