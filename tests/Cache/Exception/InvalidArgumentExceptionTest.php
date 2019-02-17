<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Exception;

use PHPUnit\Framework\TestCase;

class InvalidArgumentExceptionTest extends TestCase
{
    public function testGetKey(): void
    {
        $this->assertContains('foo', (new InvalidArgumentException('foo'))->getMessage());
    }
}
