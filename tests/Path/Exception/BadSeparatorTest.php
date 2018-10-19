<?php
/**
 * The file for the "bad path separator" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "bad path separator" exception
 *
 * @since  0.1.0
 */
class BadSeparatorTest extends TestCase
{
    public function testGetPath(): void
    {
        $this->assertEquals('foo', (new BadSeparator('foo'))->getPath());

        return;
    }
}
