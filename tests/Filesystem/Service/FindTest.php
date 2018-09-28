<?php
/**
 * The file for the find-filesystem service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the find-filesystem service
 *
 * @since  0.1.0
 * @todo
 */
class FindTest extends TestCase
{
    public function testInvokeReturnsNullIfNotComposer(): void
    {
        $this->assertNull((new Find())());

        return;
    }

    // public function testInvokeReturnsSplFilInfoIfComposer(): void
    // {
    //     // how the heck do I test this?
    // }
}
