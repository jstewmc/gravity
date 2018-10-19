<?php
/**
 * The file for the "bad id length" exception tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "bad id length" exception
 *
 * @since  0.1.0
 */
class BadLengthTest extends TestCase
{
    public function testGetId(): void
    {
        $this->assertSame('foo', (new BadLength('foo'))->getPath());

        return;
    }
}
