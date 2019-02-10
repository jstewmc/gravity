<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Data;

use PHPUnit\Framework\TestCase;

class TraversedTest extends TestCase
{
    public function testGetFiles(): void
    {
        $this->assertEquals([], (new Traversed([]))->getFiles());
    }
}
