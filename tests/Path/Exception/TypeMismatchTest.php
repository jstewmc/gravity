<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
class TypeMismatchTest extends TestCase
{
    public function testGetA(): void
    {
        $a = $this->createMock(Path::class);
        $b = $this->createMock(Path::class);

        $exception = new TypeMismatch($a, $b);

        $this->assertSame($a, $exception->getA());

        return;
    }

    public function testGetB(): void
    {
        $a = $this->createMock(Path::class);
        $b = $this->createMock(Path::class);

        $exception = new TypeMismatch($a, $b);

        $this->assertSame($b, $exception->getB());

        return;
    }
}
