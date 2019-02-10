<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    public function testConstruct()
    {
        $this->expectException(Circular::class);

        $deprecation = new Read('foo', 'foo');

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
        $replacement = $this->createMock(Path::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }

    private function mockSource($path = 'foo'): string
    {
        $source = $this->createMock(Path::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }
}
