<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Exception;

use PHPUnit\Framework\TestCase;

class NotFoundTest extends TestCase
{
    public function testGetKey(): void
    {
        $this->assertSame('foo', (new NotFound('foo'))->getKey());

        return;
    }
}
