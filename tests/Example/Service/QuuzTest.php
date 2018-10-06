<?php
/**
 * The file for the "quuz" example tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "quuz" example service
 *
 * @since  0.1.0
 */
class QuuzTest extends TestCase
{
    public function testInvoke(): void
    {
        $this->assertEquals('quuz', (new Quuz())());

        return;
    }
}
