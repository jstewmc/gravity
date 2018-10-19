<?php
/**
 * The file for the "bad path length" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "bad length" exception
 *
 * @since  0.1.0
 */
class BadLengthTest extends TestCase
{
    public function testConstruct(): void
    {
        // make sure the constructor "works"
        $this->assertInstanceOf(BadLength::class, (new BadLength()));

        return;
    }
}
