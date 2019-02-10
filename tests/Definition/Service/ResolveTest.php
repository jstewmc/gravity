<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Definition\Data\{Parsed, Resolved};
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;
use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    public function testInvoke(): void
    {
        $id = $this->createMock(Id::class);

        $resolvePath = $this->createMock(ResolvePath::class);
        $resolvePath->method('__invoke')->willReturn($id);

        $sut = new Resolve($resolvePath);

        $path       = $this->createMock(Path::class);
        $definition = new Parsed($path);
        $namespace  = $this->createMock(Ns::class);

        $expected = new Resolved($id);
        $actual   = $sut($definition, $namespace);

        $this->assertEquals($expected, $actual);

        return;
    }
}
