<?php
/**
 * The file for the "corge" example tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the "corge" example service
 *
 * @since  0.1.0
 */
class CorgeTest extends TestCase
{
    public function testInvoke(): void
    {
        $quuz = $this->getMockBuilder(Quuz::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $quuz->expects($this->once())->method('__invoke');

        (new Corge($quuz))();

        return;
    }
}
