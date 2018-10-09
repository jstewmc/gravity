<?php
/**
 * The file for the cache "not found" exception tests
 *
 * @author     Jack Clayton <claysj0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the cache's not found exception
 *
 * @since  0.1.0
 */
class NotFoundTest extends TestCase
{
    public function testGetKey(): void
    {
        $this->assertSame('foo', (new NotFound('foo'))->getKey());

        return;
    }
}
