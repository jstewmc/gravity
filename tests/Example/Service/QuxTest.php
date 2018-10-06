<?php
/**
 * The file for the "qux" example tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "qux" example service
 *
 * @since  0.1.0
 */
class QuxTest extends TestCase
{
    public function testInvoke(): void
    {
        $this->assertEquals('qux', (new Qux())());

        return;
    }
}
