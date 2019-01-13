<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\Circular;
use Jstewmc\Gravity\Alias\Exception\TypeMismatch;
use Jstewmc\Gravity\Id\Data as Id;
use Jstewmc\Gravity\Path\Data as Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  alias
 */
class ResolvedTest extends TestCase
{
    public function testConstructThrowsExceptionIfCircular(): void
    {
        $this->expectException(Circular::class);

        $id = $this->createMock(Id\Id::class);

        new Resolved($id, $id);

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $alias = new Resolved($source, $this->mockDestination());

        $this->assertSame($source, $alias->getSource());

        return;
    }

    public function testGetDestination(): void
    {
        $destination = $this->mockDestination();

        $alias = new Resolved($this->mockSource(), $destination);

        $this->assertSame($destination, $alias->getDestination());

        return;
    }

    private function mockSource($path = 'foo')
    {
        $source = $this->createMock(Id\Service::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }

    private function mockDestination($path = 'bar')
    {
        $destination = $this->createMock(Id\Service::class);
        $destination->method('__toString')->willReturn($path);

        return $destination;
    }
}
