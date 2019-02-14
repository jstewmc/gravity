<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\{Circular, TypeMismatch};
use Jstewmc\Gravity\Path\Data\{Path, Service, Setting};
use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    public function testConstructThrowsExceptionIfCircular()
    {
        $this->expectException(Circular::class);

        $source      = new Service(['foo', 'bar', 'baz']);
        $destination = new Service(['foo', 'bar', 'baz']);

        new Parsed($source, $destination);

        return;
    }

    public function testConstructThrowsExceptionIfTypeMismatch()
    {
        $this->expectException(TypeMismatch::class);

        $source      = new Service(['foo', 'bar', 'baz']);
        $destination = new Setting(['foo', 'bar', 'baz']);

        new Parsed($source, $destination);

        return;
    }

    public function testGetReplacement(): void
    {
        $replacement = $this->mockReplacement();

        $deprecation = new Parsed($this->mockSource(), $replacement);

        $this->assertSame($replacement, $deprecation->getReplacement());

        return;
    }

    public function testGetSource(): void
    {
        $source = $this->mockSource();

        $deprecation = new Parsed($source);

        $this->assertSame($source, $deprecation->getSource());

        return;
    }

    public function testHasReplacement(): void
    {
        $deprecation = new Parsed($this->mockSource(), $this->mockReplacement());

        $this->assertTrue($deprecation->hasReplacement());

        return;
    }

    private function mockReplacement($path = 'bar'): Path
    {
        $replacement = $this->createMock(Path::class);
        $replacement->method('__toString')->willReturn($path);

        return $replacement;
    }

    private function mockSource($path = 'foo'): Path
    {
        $source = $this->createMock(Path::class);
        $source->method('__toString')->willReturn($path);

        return $source;
    }
}
