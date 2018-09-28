<?php
/**
 * The file for the service identifier tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use PHPUnit\Framework\TestCase;

/**
 * Tests for a Id  identifier
 *
 * @since  0.1.0
 * @group  identifier
 */
class ServiceTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals(
            'foo\bar\baz',
            (string) new Service(['foo', 'bar', 'baz'])
        );

        return;
    }

    public function testGetSegments(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $this->assertEquals($segments,(new Service($segments))->getSegments());

        return;
    }
}
