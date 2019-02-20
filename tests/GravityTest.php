<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use PHPUnit\Framework\TestCase;
use Psr\Log;
use Psr\SimpleCache\CacheInterface as Cache;

class GravityTest extends TestCase
{
    public function testPull(): void
    {
        $this->assertInstanceOf(Manager\Data\Manager::class, (new Gravity())->pull());
    }

    public function testSetLogger(): void
    {
        $gravity = new Gravity();

        $logger = $this->createMock(Log\LoggerInterface::class);

        $this->assertSame($gravity, $gravity->setLogger($logger));
    }

    public function testSetCache(): void
    {
        $gravity = new Gravity();

        $cache = $this->createMock(Cache::class);

        $this->assertSame($gravity, $gravity->setCache($cache));
    }
}
