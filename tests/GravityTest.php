<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use PHPUnit\Framework\TestCase;

class GravityTest extends TestCase
{
    public function testPull(): void
    {
        $this->assertInstanceOf(Manager\Data\Manager::class, (new Gravity())->pull());
    }

    public function testSetCache(): void
    {
        $gravity = new Gravity();

        $cache = $this->createMock(Cache\Data\Cache::class);

        $this->assertSame($gravity, $gravity->setCache($cache));
    }
}
