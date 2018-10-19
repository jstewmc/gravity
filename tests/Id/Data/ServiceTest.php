<?php
/**
 * The file for service id tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Path\Data\Service as Path;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a service id
 *
 * @since  0.1.0
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
}
