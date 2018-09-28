<?php
/**
 * The file for the setting identifier tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use PHPUnit\Framework\TestCase;

/**
 * Tests for a setting identifier
 *
 * @since  0.1.0
 * @group  identifier
 */
class SettingTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals(
            'foo.bar.baz',
            (string) new Setting(['foo', 'bar', 'baz'])
        );

        return;
    }

    public function testGetSegments(): void
    {
        $segments = ['foo', 'bar', 'baz'];

        $this->assertEquals($segments, (new Setting($segments))->getSegments());

        return;
    }
}
