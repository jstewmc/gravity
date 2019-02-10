<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;
use PHPUnit\Framework\TestCase;

class ReadTest extends TestCase
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

    private function mockSource(): string
    {
        return 'foo';
    }

    private function mockReplacement(): string
    {
        return 'bar';
    }
}
