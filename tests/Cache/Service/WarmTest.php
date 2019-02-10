<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Service;

use Jstewmc\Gravity\Cache\Data\Hash;
use PHPUnit\Framework\TestCase;

/**
 * @group  cache
 */
class WarmTest extends TestCase
{
    public function testInvoke(): void
    {
        $cache = new Hash();

        $sut = new Warm();

        $this->assertSame($cache, $sut($cache));
    }
}
