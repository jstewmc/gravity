<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @group  path
 */
class EmptyPathTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(EmptyPath::class, (new EmptyPath()));
    }
}
