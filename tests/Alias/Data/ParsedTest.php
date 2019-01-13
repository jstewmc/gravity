<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\Circular;
use Jstewmc\Gravity\Alias\Exception\TypeMismatch;
use Jstewmc\Gravity\Path\Data as Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  alias
 */
class ParseTest extends TestCase
{
    public function testConstructThrowsExceptionIfCircular(): void
    {
        $this->expectException(Circular::class);

        $path = $this->createMock(Path\Path::class);

        new Parsed($path, $path);

        return;
    }

    public function testConstructThrowsExceptionIfTypeMismatch(): void
    {
        $this->expectException(TypeMismatch::class);

        // hmm, use concrete paths because PHPUnit Mocks are the same class
        $source      = new Path\Service(['foo', 'bar', 'baz']);
        $destination = new Path\Setting(['foo', 'bar', 'baz']);

        new Parsed($source, $destination);

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $alias = new Parsed($source, $this->mockDestination());

        $this->assertSame($source, $alias->getSource());

        return;
    }

    public function testGetDestination(): void
    {
        $destination = $this->mockDestination();

        $alias = new Parsed($this->mockSource(), $destination);

        $this->assertSame($destination, $alias->getDestination());

        return;
    }

    private function mockSource($path = 'foo')
    {
        $source = $this->createMock(Path\Service::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }

    private function mockDestination($path = 'bar')
    {
        $destination = $this->createMock(Path\Service::class);
        $destination->method('__toString')->willReturn($path);

        return $destination;
    }
}
