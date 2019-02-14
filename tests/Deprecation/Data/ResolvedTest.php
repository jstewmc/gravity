<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

class ResolvedTest extends TestCase
{
    public function testConstruct()
    {
        $this->expectException(Circular::class);

        $source      = $this->mockSource();
        $destination = $source;

        $deprecation = new Resolved($source, $destination);

        return;
    }

    public function testGetReplacement(): void
    {
        $replacement = $this->mockReplacement();

        $deprecation = new Resolved($this->mockSource(), $replacement);

        $this->assertSame($replacement, $deprecation->getReplacement());

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $deprecation = new Resolved($source);

        $this->assertSame($source, $deprecation->getSource());

        return;
    }

    public function testHasReplacement(): void
    {
        $deprecation = new Resolved($this->mockSource(), $this->mockReplacement());

        $this->assertTrue($deprecation->hasReplacement());

        return;
    }

    private function mockReplacement($path = 'bar'): Id
    {
        $replacement = $this->createMock(Id::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }

    private function mockSource($path = 'foo'): Id
    {
        $source = $this->createMock(Id::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }
}
