<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * @group  example
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
