<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\{Id, Manager, Project};
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface;
use StdClass;

class GetTest extends TestCase
{
    public function testInvokeIfCached(): void
    {
        $instance = $this->mockInstance();
        $cache    = $this->mockCache(true);
        $cache->method('get')->willReturn($instance);

        $instantiate = $this->mockInstantiate();

        $sut = new Get($instantiate, $cache, $this->mockLogger());

        // set up throw-away arguments
        $id      = $this->mockId();
        $project = $this->mockProject();
        $manager = $this->mockManager();

        $expected = $instance;
        $actual   = $sut($id, $project, $manager);

        $this->assertEquals($expected, $actual);
    }

    public function testInvokeIfNotCached(): void
    {
        $cache = $this->mockCache(false);

        $service = $this->mockService();
        $project = $this->mockProject();
        $project->method('getService')->willReturn($service);

        $instance    = $this->mockInstance();
        $instantiate = $this->mockInstantiate();
        $instantiate->method('__invoke')->willReturn($instance);

        $sut = new Get($instantiate, $cache, $this->mockLogger());

        // set up throw-away arguments
        $id      = $this->mockId();
        $manager = $this->mockManager();

        $expected = $instance;
        $actual   = $sut($id, $project, $manager);

        $this->assertEquals($expected, $actual);

        return;
    }

    private function mockCache($isCached): CacheInterface
    {
        $cache = $this->createMock(CacheInterface::class);
        $cache->method('has')->willReturn($isCached);

        return $cache;
    }

    private function mockId(): Id\Data\Service
    {
        return $this->createMock(Id\Data\Service::class);
    }

    private function mockInstance(): StdClass
    {
        return $this->createMock(StdClass::class);
    }

    private function mockInstantiate(): Instantiate
    {
        return $this->createMock(Instantiate::class);
    }

    private function mockLogger(): Logger
    {
        return $this->createMock(Logger::class);
    }

    private function mockManager(): Manager\Data\Manager
    {
        return $this->createMock(Manager\Data\Manager::class);
    }

    private function mockProject(): Project\Data\Project
    {
        return $this->createMock(Project\Data\Project::class);
    }

    private function mockService(): \Jstewmc\Gravity\Service\Data\Service
    {
        return $this->createMock(\Jstewmc\Gravity\Service\Data\Service::class);
    }
}
