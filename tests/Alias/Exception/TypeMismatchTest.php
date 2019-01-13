<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Alias\Exception\TypeMismatch;
use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  alias
 */
class TypeMismatchTest extends TestCase
{
    public function testGetDestination(): void
    {
        $destination = $this->mockDestination();

        $exception = new TypeMismatch($this->mockSource(), $destination);

        $this->assertSame($destination, $exception->getDestination());

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $exception = new TypeMismatch($source, $this->mockDestination());

        $this->assertSame($source, $exception->getSource());

        return;
    }

    private function mockSource()
    {
        return $this->createMock(Path::class);
    }

    private function mockDestination()
    {
        return $this->createMock(Path::class);
    }
}
