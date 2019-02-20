<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use PHPUnit\Framework\TestCase;

class InvalidSeparatorTest extends TestCase
{
    public function testGetPath(): void
    {
        $this->assertEquals('foo', (new InvalidSeparator('foo', ''))->getPath());

        return;
    }
}
