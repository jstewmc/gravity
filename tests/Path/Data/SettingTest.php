<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

use Jstewmc\Gravity\Path\Exception\EmptyPath;
use PHPUnit\Framework\TestCase;

class SettingTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->expectException(EmptyPath::class);

        new Setting([]);
    }

    public function testToString(): void
    {
        $this->assertEquals(
            'foo.bar.baz',
            (string)new Setting(['foo', 'bar', 'baz'])
        );
    }

    public function testGetFirstSegment(): void
    {
        $this->assertEquals(
            'foo',
            (new Setting(['foo', 'baz', 'baz']))->getFirstSegment()
        );
    }

    public function testGetLastSegment(): void
    {
        $this->assertEquals(
            'baz',
            (new Setting(['foo', 'bar', 'baz']))->getLastSegment()
        );
    }

    public function testGetLength(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $this->assertEquals(
            count($segments),
            (new Service($segments))->getLength()
        );
    }

    public function testGetLowecaseSegments(): void
    {
        $segments = ['FOO', 'BAR', 'BAZ'];

        $this->assertEquals(
            ['foo', 'bar', 'baz'],
            (new Setting($segments))->getLowercaseSegments()
        );
    }

    public function testGetOriginaCaseSegments(): void
    {
        $segments = ['FOO', 'bar', 'BAZ'];

        $this->assertEquals(
            $segments,
            (new Setting($segments))->getOriginalCaseSegments()
        );
    }

    public function testGetSegments(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $this->assertEquals(
            $segments,
            (new Service($segments))->getSegments()
        );
    }

    public function testHasLeadingSeparator(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertFalse($path->hasLeadingSeparator());
    }

    public function testHasTrailingSeparator(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertFalse($path->hasTrailingSeparator());
    }

    public function testPopSegment(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertEquals('baz', $path->popSegment());
    }

    public function testSetHasLeadingSeparator(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertSame($path, $path->setHasLeadingSeparator(true));
    }

    public function testSetHasTrailingSeparator(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertSame($path, $path->setHasLeadingSeparator(true));
    }

    public function testShiftSegment(): void
    {
        $path = new Setting(['foo', 'bar', 'baz']);

        $this->assertEquals('foo', $path->shiftSegment());
    }
}
