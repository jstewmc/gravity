<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
class ServiceTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals(
            'foo\bar\baz',
            (string)new Service(['foo', 'bar', 'baz'])
        );
    }

    public function testGetFirstSegment(): void
    {
        $path = new Service(['foo', 'baz', 'baz']);

        $this->assertEquals('foo', $path->getFirstSegment());
    }

    public function testGetLastSegment(): void
    {
        $path = new Service(['foo', 'baz', 'baz']);

        $this->assertEquals('baz', $path->getLastSegment());
    }

    public function testGetLength(): void
    {
        $segments = ['foo', 'bar'];

        $this->assertEquals(
            count($segments),
            (new Service($segments))->getLength()
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
        $path = new Service(['foo', 'baz', 'baz']);

        $this->assertFalse($path->hasLeadingSeparator());
    }

    public function testHasTrailingSeparator(): void
    {
        $path = new Service(['foo', 'baz', 'baz']);

        $this->assertFalse($path->hasTrailingSeparator());
    }

    public function popSegment(): void
    {
        $path = new Service(['foo', 'bar', 'baz']);

        $this->assertEquals('baz', $path->popSegment());
    }

    public function testSetHasLeadingSeparator(): void
    {
        $path = new Service(['foo', 'bar', 'baz']);

        $this->assertSame($path, $path->setHasLeadingSeparator(true));
    }

    public function testSetHasTrailingSeparator(): void
    {
        $path = new Service(['foo', 'bar', 'baz']);

        $this->assertSame($path, $path->setHasLeadingSeparator(true));
    }

    public function shiftSegment(): void
    {
        $path = new Service(['foo', 'bar', 'baz']);

        $this->assertEquals('foo', $path->shiftSegment());
    }
}
