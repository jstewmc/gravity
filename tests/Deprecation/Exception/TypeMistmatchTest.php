<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Deprecation\Exception\TypeMismatch;
use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  deprecation
 */
class TypeMismatchTest extends TestCase
{
    public function testGetReplacement(): void
    {
        $replacement = $this->mockReplacement();

        $exception = new TypeMismatch($this->mockSource(), $replacement);

        $this->assertSame($replacement, $exception->getReplacement());

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $exception = new TypeMismatch($source, $this->mockReplacement());

        $this->assertSame($source, $exception->getSource());

        return;
    }

    private function mockSource()
    {
        return $this->createMock(Path::class);
    }

    private function mockReplacement()
    {
        return $this->createMock(Path::class);
    }
}
