<?php
/**
 * The file for the "quux" example tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "quux" example service
 *
 * @since  0.1.0
 */
class QuuxTest extends TestCase
{
    public function testInvoke(): void
    {
        $this->assertEquals('quux', (new Quux())());

        return;
    }
}
