<?php
/**
 * The file for the "bad length" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "bad length" exception
 *
 * @since  0.1.0
 */
class BadLengthTest extends TestCase
{
    public function testGetIdenfifier(): void
    {
        $this->assertEquals('foo', (new BadLength('foo'))->getId());

        return;
    }
}
