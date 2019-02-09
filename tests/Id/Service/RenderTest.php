<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\{Id, Ns, Path};
use PHPUnit\Framework\TestCase;

/**
 * @group  id
 */
class RenderTest extends TestCase
{
    public function testInvoke(): void
    {
        $path  = $this->createMock(Path\Data\Path::class);
        $parse = $this->createMock(Path\Service\Parse::class);
        $parse->method('__invoke')->willReturn($path);


        $id      = $this->createMock(Id\Data\Id::class);
        $resolve = $this->createMock(Path\Service\Resolve::class);
        $resolve->method('__invoke')->willReturn($id);

        $sut = new Render($parse, $resolve);

        // prepare throw-away arguments
        $path      = 'Foo\Bar\Baz';
        $namespace = $this->createMock(Ns\Data\Parsed::class);

        $expected = $id;
        $actual   = $sut($path, $namespace);

        $this->assertEquals($expected, $actual);
    }
}
