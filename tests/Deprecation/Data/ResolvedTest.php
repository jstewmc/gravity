<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * @group deprecation
 */
class ResolvedTest extends TestCase
{
    public function testConstruct()
    {
        $this->expectException(Circular::class);

        $source      = $this->mockSource();
        $destination = $source;

        $deprecation = new Read($source, $destination);

        return;
    }

    public function testGetReplacement(): void
    {
        $replacement = $this->mockReplacement();

        $deprecation = new Read($this->mockSource(), $replacement);

        $this->assertSame($replacement, $deprecation->getReplacement());

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $deprecation = new Read($source);

        $this->assertSame($source, $deprecation->getSource());

        return;
    }

    public function testHasReplacement(): void
    {
        $deprecation = new Read($this->mockSource(), $this->mockReplacement());

        $this->assertTrue($deprecation->hasReplacement());

        return;
    }

    private function mockReplacement($path = 'bar'): string
    {
        $replacement = $this->createMock(Id::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }

    private function mockSource($path = 'foo'): string
    {
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }
}
