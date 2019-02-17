<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\{Id, Project};
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface;

class GetTest extends TestCase
{
    public function testInvokeIfCached(): void
    {
        $value = 1;
        $cache = $this->mockCache(true);
        $cache->method('get')->willReturn($value);

        $sut = new Get($cache, $this->mockLogger());

        // set up throw-away arguments
        $id      = $this->mockId();
        $project = $this->mockProject();

        $expected = $value;
        $actual   = $sut($id, $project);

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeIfNotCached(): void
    {
        $cache = $this->mockCache(false);

        $value   = 1;
        $project = $this->mockProject();
        $project->method('getSetting')->willReturn($value);

        $sut = new Get($cache, $this->mockLogger());

        // set up throw-away arguments
        $id = $this->mockId();

        $expected = $value;
        $actual   = $sut($id, $project);

        $this->assertEquals($expected, $actual);

        return;
    }

    private function mockCache($isCached): CacheInterface
    {
        $cache = $this->createMock(CacheInterface::class);
        $cache->method('has')->willReturn($isCached);

        return $cache;
    }

    private function mockId(): Id\Data\Setting
    {
        return $this->createMock(Id\Data\Setting::class);
    }

    private function mockLogger(): Logger
    {
        return $this->createMock(Logger::class);
    }

    private function mockProject(): Project\Data\Project
    {
        return $this->createMock(Project\Data\Project::class);
    }
}
