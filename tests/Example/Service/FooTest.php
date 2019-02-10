<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    public function testInvoke(): void
    {
        $this->assertEquals('foo', (new Foo())());

        return;
    }
}
