<?php
/**
 * The file for the service path tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

use PHPUnit\Framework\TestCase;

/**
 * Tests for a service path
 *
 * @since  0.1.0
 */
class ServiceTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals(
            'foo\bar\baz',
            (string)new Service(['foo', 'bar', 'baz'])
        );

        return;
    }

    public function testGetLength(): void
    {
        $segments = ['foo', 'bar'];

        $this->assertEquals(
            count($segments),
            (new Service($segments))->getLength()
        );

        return;
    }

    public function testGetSegments(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $this->assertEquals(
            $segments,
            (new Service($segments))->getSegments()
        );

        return;
    }
}