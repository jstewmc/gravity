<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Path\Data\Service as Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  id
 */
class ServiceTest extends TestCase
{
    public function testToString(): void
    {
        $string = 'foo\bar\baz';

        $path = $this->createMock(Path::class);
        $path->method('__toString')->willReturn($string);
        $path->method('getLength')->willReturn(3);

        $id = new Service($path);

        $this->assertEquals($string, (string)$id);

        return;
    }

    public function testGetPath(): void
    {
        $path = $this->createMock(Path::class);
        $path->method('getLength')->willReturn(3);

        $id = new Service($path);

        $this->assertSame($path, $id->getPath());

        return;
    }

    public function testGetSegments(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $path = $this->createMock(Path::class);
        $path->method('getLength')->willReturn(3);
        $path->method('getSegments')->willReturn($segments);

        $this->assertEquals($segments, (new Service($path))->getSegments());
    }
}
